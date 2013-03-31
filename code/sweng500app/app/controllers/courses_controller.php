<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: CoursesController.php
 * Description: This controller provides request handling for courses data
 * Created: 2013-02-21
 * Modified: 2013-03-23 10:04
 * Modified By: David Singer
*/

class CoursesController extends AppController {

    var $name = 'Courses';
	var $uses = array('Course','Lesson', 'LessonStatus');
	
	 function index() {

	$this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc'), 'group' => array('Course.id')));
	if (($this->Auth->user('type_id')) ==3) {  //Student 	
      		$courses = $this->paginate('Course', array('Course.course_status' => 'C')); }
                   else{
	/*$this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc')));*/
        	$courses = $this->paginate('Course');}
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name')));

    	$this->set(compact('users', 'courses'));
		if (($this->Auth->user('type_id')) ==3)   //Student (not Admin or Instructor)
      	{
      		$this->render('index_student');          //Redirect to limited functionality page
      	}
    }
	
	function indexCurrent() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc'), 'group' => array('Course.id')));

        $courses = $this->paginate('Course', array('Course.course_status'=>'C'));
        
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name')));
    	$this->set(compact('users', 'courses'));
    }
	
	function indexArchived() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc'), 'group' => array('Course.id')));

        $courses = $this->paginate('Course', array('Course.course_status'=>'A'));
        
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name')));
    	$this->set(compact('users', 'courses'));
    }
	
	function indexUnderDevelopment() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc'), 'group' => array('Course.id')));

        $courses = $this->paginate('Course', array('Course.course_status'=>'U'));
        
    	$this->loadModel('User');
    	$users = $this->Course->User->find('list', array('fields' => array('name')));
    	$this->set(compact('users', 'courses'));
    }
	
	function add () {
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
	      if ($this->Course->Roster->validates()) {
	         $this->Course->Roster->save($this->data);
	         $this->Session->setFlash('Course has been added to your Course Roster');
	      }
	      else  {
	         $errors = $this->Course->Roster->invalidFields();
	         $this->Session->setFlash(implode(',', $errors));
	      }
		  $this->redirect($this->referer());
                  
    }


	function search() {  
		$this->render('search');  
	}
	
	
	function searchResults() {
		if(!empty($this->data )) {    //not working - always returns true even if field is blank
			$data = $this->paginate('Course', array('','Course.course_name LIKE' => '%' . $this->data['Course']['course_name'] . '%'));
			$this->set('courses', $data);
			$this->render('index_student');
		}else {
			$this->Session->setFlash('Please enter keyword to search for'); 
			$this->redirect(array('controller'=>'courses', 'action' => 'search'));
		}                    
    }

	function launch($id = null) {
		
		
		$this->Lesson->recursive= 1;
		$this->paginate = array(
			'Lesson' => array(
				'conditions' => array('Lesson.course_id' => $id),
				'fields' => array('Lesson.id', 'Lesson.name')
			),
			'LessonStatus' => array(
				'conditions' => array('Lesson.id' => 'LessonStatus.lesson_id'),
				'fields' => array('LessonStatus.status')
			)
		);
		$lessons = $this->paginate('Lesson');

		
		$this->set('lessons', $lessons);
		
		$roster_course = $this->Course->Roster->find('first', array(
			'conditions' => array('Roster.user_id' => $this->Auth->user('id'), 
				'Roster.course_id' => $id)

		));
		$this->set('roster_course', $roster_course);
		
		$this->Course->id = $id;
		$course = $this->Course->read();
		
		$this->set('course', $course);
	
		$this->Lesson->unbindModel(array(
			'belongsTo' => array('Lesson')));
		$this->Lesson->bindModel(array(
			'hasOne' => array(
				'LessonStatus' => array(
					'foreignKey' => false,
					'conditions' => array('LessonStatus.lesson_id = Lesson.id')
				)
			)
		));
		$this->Lesson->recursive= 1;
		$count_complete=$this->Lesson->find('count', array(
			'conditions' => array(
				'Lesson.course_id' => $id,
				'LessonStatus.user_id' => $this->Auth->user('id')
			),                               
			'contain' => array('Lesson', 'LessonStatus')
		));
		
		$count_lessons = $this->Lesson->find('count', array(
			'conditions' => array('Lesson.course_id' => $id)
		));
		
		$status = 'Complete';
		if($roster_course['Roster']['completion_status'] != 'Complete') {
			if($count_complete - $count_lessons == 0) {
				if(!empty($course['Quiz']['id'])) {
					$status = 'Incomplete';
					$quizSub = $this->Course->Quiz->QuizSubmission->find('first', 
						array('conditions' => array('quiz_id' => $course['Quiz']['id'],
							'user_id' => $this->Auth->user('id'))));
					if(!empty($quizSub)) {
						$status = 'Complete';
					}
				} else { 
					// there is no course test. 
					$status = 'Complete';
				}
				if($status == 'Complete') {
					$roster_course['Roster']['completion_status'] = $status;
					$this->Course->Roster->id = $roster_course['Roster']['id'];
					$this->Course->Roster->saveField('completion_status', 'Complete');
					$this->Session->setFlash('Congratulations, you have completed this course');
				}
				
			} else { 
				$status = 'Incomplete';
			}
		} 
		
		$this->set('status', $status);
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
			
			// Archive Course Quizzes
			
			$this->loadModel('Quiz');
			$quizzes = $this->Quiz->find('all', array('conditions' => array('Quiz.course_id' => $course_archive_id)));
		
			foreach ($quizzes as $quiz):
				$quiz_archive_id   = $quiz['Quiz']['id'];
				$quiz_data   = array($quiz['Quiz']['lesson_id'],
									 $quiz['Quiz']['course_id'],
								 	 $quiz['Quiz']['name'],
									 $quiz['Quiz']['created'],
									 $quiz['Quiz']['modified']);
				$quiz_imploded_data = implode("@,=", $quiz_data);
				$zip->addFromString('cquiz' . $quiz_archive_id . 'course' . $course_archive_id . '.imp', $quiz_imploded_data);
					
				// Archive Course Questions
					
				$this->loadModel('Question');
				$questions = $this->Question->find('all', array('conditions' => array('Question.quiz_id' => $quiz_archive_id)));
		
				foreach ($questions as $question):
					$question_archive_id = $question['Question']['id'];
					$quiz_archive_id     = $question['Question']['quiz_id'];
					$question_data = array($question['Question']['type'],
									 	   $question['Question']['points'],
										   $question['Question']['question'],
										   $question['Question']['created'],
										   $question['Question']['modified']);
					$question_imploded_data = implode("@,=", $question_data);
					$zip->addFromString('question' . $question_archive_id . 'quiz' . $quiz_archive_id . 'course' . $course_archive_id . '.imp', $question_imploded_data);
						
					// Archive Course Answers
					
					$this->loadModel('Answer');
					$answers = $this->Answer->find('all', array('conditions' => array('Answer.question_id' => $question_archive_id)));
		
					foreach ($answers as $answer):
						$answer_archive_id   = $answer['Answer']['id'];
						$question_archive_id = $answer['Answer']['question_id'];
						$answer_data   = array($answer['Answer']['value'],
										 	   $answer['Answer']['correct'],
											   $answer['Answer']['created'],
											   $answer['Answer']['modified']);
						$answer_imploded_data = implode("@,=", $answer_data);
						$zip->addFromString('zanswer' . $answer_archive_id . 'question' . $question_archive_id . 'course' . $course_archive_id . '.imp', $answer_imploded_data);
						
					endforeach;
					$this->Answer->deleteAll(array('Answer.question_id' => $question_archive_id), false);	
						
				endforeach;
				$this->Question->deleteAll(array('Question.quiz_id' => $quiz_archive_id), false);
					
			endforeach;
			$this->Quiz->deleteAll(array('Quiz.course_id' => $course_archive_id), false);
			
			// Archive Lessons
						
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
				
				// Archive Lesson Contents
			
				$this->loadModel('LessonContent');
				$contents = $this->LessonContent->find('all', array('conditions' => array('LessonContent.lesson_id' => $lesson_archive_id)));
		
				foreach ($contents as $content):
					$content_archive_id = $content['LessonContent']['id'];
					$lesson_archive_id  = $content['LessonContent']['lesson_id'];
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
				
				// Archive Lesson Quizzes
			
				$this->loadModel('Quiz');
				$quizzes = $this->Quiz->find('all', array('conditions' => array('Quiz.lesson_id' => $lesson_archive_id)));
		
				foreach ($quizzes as $quiz):
					$quiz_archive_id   = $quiz['Quiz']['id'];
					$lesson_archive_id = $quiz['Quiz']['lesson_id'];
					$quiz_data   = array($quiz['Quiz']['course_id'],
									 	 $quiz['Quiz']['name'],
										 $quiz['Quiz']['created'],
										 $quiz['Quiz']['modified']);
					$quiz_imploded_data = implode("@,=", $quiz_data);
					$zip->addFromString('lquiz' . $quiz_archive_id . 'lesson' . $lesson_archive_id . 'course' . $course_archive_id . '.imp', $quiz_imploded_data);
					
					// Archive Lesson Questions
					
					$this->loadModel('Question');
					$questions = $this->Question->find('all', array('conditions' => array('Question.quiz_id' => $quiz_archive_id)));
		
					foreach ($questions as $question):
						$question_archive_id = $question['Question']['id'];
						$quiz_archive_id     = $question['Question']['quiz_id'];
						$question_data = array($question['Question']['type'],
										 	   $question['Question']['points'],
											   $question['Question']['question'],
											   $question['Question']['created'],
											   $question['Question']['modified']);
						$question_imploded_data = implode("@,=", $question_data);
						$zip->addFromString('question' . $question_archive_id . 'quiz' . $quiz_archive_id . 'course' . $course_archive_id . '.imp', $question_imploded_data);
						
						// Archive Lesson Answers
					
						$this->loadModel('Answer');
						$answers = $this->Answer->find('all', array('conditions' => array('Answer.question_id' => $question_archive_id)));
		
						foreach ($answers as $answer):
							$answer_archive_id   = $answer['Answer']['id'];
							$question_archive_id = $answer['Answer']['question_id'];
							$answer_data   = array($answer['Answer']['value'],
											 	   $answer['Answer']['correct'],
												   $answer['Answer']['created'],
												   $answer['Answer']['modified']);
							$answer_imploded_data = implode("@,=", $answer_data);
							$zip->addFromString('zanswer' . $answer_archive_id . 'question' . $question_archive_id . 'course' . $course_archive_id . '.imp', $answer_imploded_data);
						
						endforeach;
						$this->Answer->deleteAll(array('Answer.question_id' => $question_archive_id), false);	
						
					endforeach;
					$this->Question->deleteAll(array('Question.quiz_id' => $quiz_archive_id), false);
					
				endforeach;
				$this->Quiz->deleteAll(array('Quiz.lesson_id' => $lesson_archive_id), false);
				
			endforeach;
			$this->Lesson->deleteAll(array('Lesson.course_id' => $course_archive_id), false);
			
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
    				case 'cont': //Extract Lesson Contents
					
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
					
    				case 'less': //Extract Lessons
					
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
					
					case 'lqui': // Extract Lesson Quizzes
					
						$lquiz_pos = 0;
						$lesson_pos = strpos($eachfile, 'lesson');
						$course_pos = strpos($eachfile, 'course');
						$lquiz_num = substr($eachfile, ($lquiz_pos + 5), ($lesson_pos - ($lquiz_pos + 5)));
						$lesson_num = substr($eachfile, ($lesson_pos + 6), ($course_pos - ($lesson_pos + 6)));
						$content_stream = file_get_contents("$extractDir/$eachfile");
						$content_data = explode('@,=', $content_stream);
						
						$this->loadModel('Quiz');
						$this->Quiz->read();
						
						$this->Quiz->set('id', $lquiz_num);
						$this->Quiz->set('lesson_id', $lesson_num);
						$this->Quiz->set('course_id', $content_data[0]);
						$this->Quiz->set('name', $content_data[1]);
						$this->Quiz->set('created', $content_data[2]);
						$this->Quiz->set('modified', $content_data[3]);
												
        				$this->Quiz->save();
						
						unlink("$extractDir/$eachfile");
					break;
					
					case 'cqui': // Extract Course Quizzes
					
						$cquiz_pos = 0;
						$course_pos = strpos($eachfile, 'course');
						$cquiz_num = substr($eachfile, ($cquiz_pos + 5), ($course_pos - ($cquiz_pos + 5)));
						$content_stream = file_get_contents("$extractDir/$eachfile");
						$content_data = explode('@,=', $content_stream);
						
						$this->loadModel('Quiz');
						$this->Quiz->read();
						
						$this->Quiz->set('id', $cquiz_num);
						$this->Quiz->set('lesson_id', $content_data[0]);
						$this->Quiz->set('course_id', $content_data[1]);
						$this->Quiz->set('name', $content_data[2]);
						$this->Quiz->set('created', $content_data[3]);
						$this->Quiz->set('modified', $content_data[4]);
												
        				$this->Quiz->save();
						
						unlink("$extractDir/$eachfile");
					
					break;
					
					case 'ques': // Extract Questions
					
						$question_pos = 0;
						$quiz_pos = strpos($eachfile, 'quiz');
						$course_pos = strpos($eachfile, 'course');
						$question_num = substr($eachfile, ($question_pos + 8), ($quiz_pos - ($question_pos + 8)));
						$quiz_num = substr($eachfile, ($quiz_pos + 4), ($course_pos - ($quiz_pos + 4)));
						$content_stream = file_get_contents("$extractDir/$eachfile");
						$content_data = explode('@,=', $content_stream);
						
						$this->loadModel('Question');
						$this->Question->read();
						
						$this->Question->set('id', $question_num);
						$this->Question->set('quiz_id', $quiz_num);
						$this->Question->set('type', $content_data[0]);
						$this->Question->set('points', $content_data[1]);
						$this->Question->set('question', $content_data[2]);
						$this->Question->set('created', $content_data[3]);
						$this->Question->set('modified', $content_data[4]);
												
        				$this->Question->save();
						
						unlink("$extractDir/$eachfile");					
					break;
					
					case 'zans': // Extract Answers
					
						$answer_pos = 0;
						$question_pos = strpos($eachfile, 'question');
						$course_pos = strpos($eachfile, 'course');
						$answer_num = substr($eachfile, ($answer_pos + 6), ($question_pos - ($answer_pos + 6)));
						$question_num = substr($eachfile, ($question_pos + 8), ($course_pos - ($question_pos + 8)));
						$content_stream = file_get_contents("$extractDir/$eachfile");
						$content_data = explode('@,=', $content_stream);
						
						$this->loadModel('Answer');
						$this->Answer->read();
						
						$this->Answer->set('id', $answer_num);
						$this->Answer->set('question_id', $question_num);
						$this->Answer->set('value', $content_data[0]);
						$this->Answer->set('correct', $content_data[1]);
						$this->Answer->set('created', $content_data[2]);
						$this->Answer->set('modified', $content_data[3]);
												
        				$this->Answer->save();
						
						unlink("$extractDir/$eachfile");
					
					break;
					
					case '.': break; // Do nothing to current directory
					
					case '..': break; // Do nothing to the parent directory
					
					default:
					unlink("$extractDir/$eachfile"); // Delete unessential files
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	