<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: CoursesController.php
 * Description: This controller provides request handling for courses data
 * Created: 2013-02-21
 * Modified: 2013-02-21 09:53
 * Modified By: David Singer
*/

class CoursesController extends AppController {

    var $name = 'Courses';
	
	 function index() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc')));

        $courses = $this->paginate('Course');

        $this->set('courses', $courses);
    }
	
	function indexCurrent() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc')));

        $courses = $this->paginate('Course', array('Course.course_status'=>'C'));

        $this->set('courses', $courses);
    }
	
	function indexArchived() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc')));

        $courses = $this->paginate('Course', array('Course.course_status'=>'A'));

        $this->set('courses', $courses);
    }
	
	function indexUnderDevelopment() {
        $this->paginate = array('Course' => array('limit' => 10, null, 'order' => array('Course.course_number' => 'asc')));

        $courses = $this->paginate('Course', array('Course.course_status'=>'U'));

        $this->set('courses', $courses);
    }
	
	 function add () 
    {
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
	$this->set('course', $course);
    }
	
	function edit($id = null) 
    {
	$this->Course->id = $id;
	$this->Course->read();
	$course = $this->Course->data;
	$this->set('course', $course);
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	