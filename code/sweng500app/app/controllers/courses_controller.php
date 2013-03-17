<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: CoursesController.php
 * Description: This controller provides request handling for courses data
 * Created: 2013-02-21
 * Modified: 2013-02-24 18:45
 * Modified By: William DiStefano
*/

class CoursesController extends AppController {

    var $name = 'Courses';
var $uses =array('Course','Lesson');
	
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
                  if ($this->Course->Roster->validates()) {
                       $this->Course->Roster->save($this->data);
                       $this->Session->setFlash('Course has been added to your Course Roster');
                  }
                  else  {
                        $errors = $this->Course->Roster->invalidFields();
                        $this->Session->setFlash(implode(',', $errors));
                  }
	$this->redirect($this->referer());
                   /*$this->redirect(array('action'=>'./index'));*/
                  
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

	function launch($id = null) {
                   
	$record = $this->Course->Roster->find('first', array(
                                     'fields' => 'id',
                             	'conditions' => array('Roster.user_id' => $this->Auth->user('id'), 
                                                                        'Roster.course_id' => $id)
                  ));

                   if($record) {
 		$this->Course->Roster->id = $record['Roster']['id']; 
                                     $this->Course->Roster->saveField("completion_status", "Incomplete");  
                  }

                  else { 
		$this->Course->Roster->create();
                   	$this->Course->Roster->set(array(
                          		 'course_id' => $id,                   
                       	 	 'user_id' => $this->Auth->user('id'),
                      	     	 'completion_status' => 'Incomplete'
                  		 ));
                 		if ($this->Course->Roster->validates()) {
                       		$this->Course->Roster->save($this->data);
                 		}
                  		else  {
                        		$errors = $this->Course->Roster->invalidFields();
                        		$this->Session->setFlash(implode(',', $errors));
                  		}
                   }
	$this->paginate = array('Lesson' => array('conditions'=> array('Lesson.course_id = ' => $id),
			'limit' => 10, null, 'order' => array('Lesson.lesson_order' => 'asc')));
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
    	
		if (!empty($this->data)){
			if ($this->Course->save($this->data)) 
			{             
				$this->Session->setFlash('Course has been saved');             
				$this->redirect(array('action' => './index'));         
			} else {
				$this->Session->setFlash('Error: unable to edit course');
			}
		}
    }
}

?>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	