<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: CoursesController.php
 * Description: This controller provides request handling for courses data
 * Created: 2013-02-21
 * Modified: 2013-03-13 19:41
 * Modified By: David Singer
*/

class CoursesController extends AppController {

    var $name = 'Courses';
	
	 function index() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc')));

        $courses = $this->paginate('Course');
        
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name')));
    	$this->set(compact('users', 'courses'));
                   if (($this->Auth->user('type_id')) ==3)   //Student (not Admin or Instructor)
                  {
                         $this->render('index_student');          //Redirect to limited functionality page
                  }
    }
	
	function indexCurrent() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc')));

        $courses = $this->paginate('Course', array('Course.course_status'=>'C'));
        
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name')));
    	$this->set(compact('users', 'courses'));
    }
	
	function indexArchived() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc')));

        $courses = $this->paginate('Course', array('Course.course_status'=>'A'));
        
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name')));
    	$this->set(compact('users', 'courses'));
    }
	
	function indexUnderDevelopment() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc')));

        $courses = $this->paginate('Course', array('Course.course_status'=>'U'));
        
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name')));
    	$this->set(compact('users', 'courses'));
    }
	
	 function add ()
    {
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name'), 
			'conditions' => array('type_id = 2')));
    	$courses = $this->Course->find('list', array('fields' => array('course_name')));
    	$this->set(compact('users', 'courses'));
    	    
		if (!empty($this->data)){
			if ($this->Course->save($this->data))
			{
				$this->Session->setFlash('New course has been added');
				$this->redirect(array('action' => './index'));
			} else {
				$this->Session->setFlash('Error: New course has not been added');
			}
		}
    }
	
	function delete($id = null) {
	$this->Course->delete($id);
	$this->Session->setFlash('Course has been deleted');
	$this->redirect(array('action'=>'./index'));
    }
	
	function view($id = null) {
	$this->Course->id = $id;
	$course = $this->Course->read();
	
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name')));
    	$courses = $this->Course->find('list', array('fields' => array('course_name')));
    	$this->set(compact('course','users', 'courses'));
    }
	

	function enroll($id = null) {
                   $this->Course->Roster->create();
                   $this->Course->Roster->set(array(
                            'course_id' => $id,                   
                            'user_id' => $this->Auth->user('id')
                   ));
                  $this->Course->Roster->save($this->data);
                  $this->Session->setFlash('Course has been added to your Course Roster');
                  $this->redirect(array('action'=>'./index'));

    }


	function search() {  $this->render('search');  }
	function searchResults() {

                  if(isset($this->data )) {    //not working - always returns true even if field is blank
 	       $data = $this->paginate('Course', array('','Course.course_name LIKE' => '%' . $this->data['Course']['course_name'] . '%'));
	       $this->set('courses', $data);
                          $this->render('index_student');
	}else {
                          $this->Session->setFlash('Please enter keyword to search for'); 
                          $this->redirect(array('controller'=>'courses', 'action' => 'search'));
                  }                    
    }


	function edit($id = null) 
    {
		$this->Course->id = $id;
		$this->Course->read();
		$course = $this->Course->data;
		$this->set('course', $course);
	
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name'), 
			'conditions' => array('type_id = 2')));
    	$courses = $this->Course->find('list', array('fields' => array('course_name')));
    	$this->set(compact('users', 'courses'));
    	
		
		if (!empty($this->data))
		{
			if ($this->Course->save($this->data)) 
			{       
				$this->Course->read();
				$course = $this->Course->data;
				$ending_status = $course['Course']['course_status'];
				if ($ending_status == "A")
				{
					$id = $course['Course']['id'];
					CoursesController::archive($id);
				}
				elseif ($ending_status == "C" OR $ending_status == "U")
				{
					$id = $course['Course']['id'];
					CoursesController::extract($id);
				}
			}
		}
    }
	
	
	function archive($id = null)
	{
	
		$this->Course->id = $id;
		$this->Course->read();
		$course = $this->Course->data;

		$course_archive_id = $id;
		
		$lesson_archive_id = null;
		
		$course_archive_number = $course['Course']['course_number'];
	
		$zip = new ZipArchive;		

		$zipper = $zip->open('../models/datasources/' . $course_archive_number . 'archive.zip');
		if ($zipper !== TRUE)
		{
			$zipper = $zip->open('../models/datasources/' . $course_archive_number . 'archive.zip', ZipArchive::CREATE);
			$zip->addFromString('readme.txt', 'field delimiter is "@,="');
						
			$this->loadModel('Lesson');
			$lessons = $this->Lesson->find('all', array('conditions' => array('Lesson.course_id' => $course_archive_id)));
		
			foreach ($lessons as $lesson):
				$lesson_archive_id = $lesson['Lesson']['id'];
				$lesson_data = array($lesson['Lesson']['name'],
									 $lesson['Lesson']['created'],
									 $lesson['Lesson']['modified'],
									 $lesson['Lesson']['main_content'],
									 $lesson['Lesson']['lesson_order']);
				$lesson_imploded_data = implode("@,=", $lesson_data);
				$zip->addFromString('lesson' . $lesson_archive_id . 'course' . $course_archive_id . '.imp', $lesson_imploded_data);
			endforeach;
			$this->Lesson->deleteAll(array('Lesson.course_id' => $course_archive_id), false);
			
			$this->loadModel('LessonContent');
			$contents = $this->LessonContent->find('all', array('conditions' => array('LessonContent.lesson_id' => $lesson_archive_id)));
		
			foreach ($contents as $content):
				$content_archive_id = $content['LessonContent']['id'];
				$lesson_archive_id = $content['LessonContent']['lesson_id'];
				$content_data = array($content['LessonContent']['filename'],
									  $content['LessonContent']['filesize'],
									  $content['LessonContent']['content'],
									  $content['LessonContent']['filetype'],
									  $content['LessonContent']['created'],
									  $content['LessonContent']['modified']);
				$content_imploded_data = implode("@,=", $content_data);
				$zip->addFromString('content' . $content_archive_id . 'lesson' . $lesson_archive_id . 'course' . $course_archive_id . '.imp', $content_imploded_data);
			endforeach;
			$this->LessonContent->deleteAll(array('LessonContent.lesson_id' => $lesson_archive_id), false);
			
			$zip->close();
	
			$this->Session->setFlash('Course has been archived');             
			$this->redirect(array('action' => './index')); 
		}
		else
		{
		$zip->close();
	
		$this->Session->setFlash('Course has been saved');             
		$this->redirect(array('action' => './index')); 
		}  
	}
	
	function extract($id = null)
	{
	
		$this->Course->id = $id;
		$this->Course->read();
		$course = $this->Course->data;

		$course_archive_id = $id;
		
		$course_archive_number = $course['Course']['course_number'];
	
		$zip = new ZipArchive;		

		$zipper = $zip->open('../models/datasources/' . $course_archive_number . 'archive.zip');
		if ($zipper === TRUE)
		{
			$extractDir = '../models/datasources/' . $course_archive_number;
			$zip->extractTo($extractDir);
    		$zip->close();
			
			
			
			$extractHandle = opendir($extractDir);
			while (($eachfile = readdir($extractHandle)) !== false)
			{	
			
				$contenttype = substr(basename($eachfile), 0, 4);
							
				switch ($contenttype) 
				{
    				case 'cont': //lessoncontent
					
						$content_pos = 0;
						$lesson_pos = strpos($eachfile, 'lesson');
						$course_pos = strpos($eachfile, 'course');
						$content_num = substr($eachfile, ($content_pos + 7), ($lesson_pos - ($content_pos + 7)));
						$lesson_num = substr($eachfile, ($lesson_pos + 6), ($course_pos - ($lesson_pos + 6)));
						$content_stream = file_get_contents("$extractDir/$eachfile");
						$content_data = explode('@,=', $content_stream);
						
						$this->loadModel('LessonContent');
						$this->LessonContent->read();
						
						$this->LessonContent->set('id', $content_num);
						$this->LessonContent->set('lesson_id', $lesson_num);
						$this->LessonContent->set('filename', $content_data[0]);
						$this->LessonContent->set('filesize', $content_data[1]);
						$this->LessonContent->set('content', $content_data[2]);
						$this->LessonContent->set('filetype', $content_data[3]);
						$this->LessonContent->set('created', $content_data[4]);
						$this->LessonContent->set('modified', $content_data[5]);
												
        				$this->LessonContent->save();
						
						unlink("$extractDir/$eachfile");
        			break;
					
    				case 'less': //lesson
					
						$lesson_pos = 0;
						$course_pos = strpos($eachfile, 'course');
						$lesson_num = substr($eachfile, ($lesson_pos + 6), ($course_pos - ($lesson_pos + 6)));
						$content_stream = file_get_contents("$extractDir/$eachfile");
						$content_data = explode('@,=', $content_stream);
						
						$this->loadModel('Lesson');
						$this->Lesson->read();
						
						$this->Lesson->set('id', $lesson_num);
						$this->Lesson->set('course_id', $course_archive_id);
						$this->Lesson->set('name', $content_data[0]);
						$this->Lesson->set('created', $content_data[1]);
						$this->Lesson->set('modified', $content_data[2]);
						$this->Lesson->set('main_content', $content_data[3]);
						$this->Lesson->set('lesson_order', $content_data[4]);
												
        				$this->Lesson->save();
						
						unlink("$extractDir/$eachfile");
					break;
					
					case '.': break;
					
					case '..': break;
					
					default:
					unlink("$extractDir/$eachfile");
					break;
				}
			}
			closedir($extractHandle);
			rmdir($extractDir);
			unlink('../models/datasources/' . $course_archive_number . 'archive.zip');
					
			$this->Session->setFlash('Course has been extracted');             
			$this->redirect(array('action' => './index'));
   		}
		else
		{
			$this->Session->setFlash('Course has been saved');             
			$this->redirect(array('action' => './index'));
		}
	}
}

?>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	