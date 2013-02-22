<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: lessons_controller.php
 * Description: 
 * Created: Feb 22, 2013
 * Modified: Feb 22, 2013 1:48:23 PM
 * Modified By: Kevin Scheib
*/

App::import('Controller', 'Lessons');
class TestLessonsController extends LessonsController {
	var $name = 'Lessons';
 
    var $autoRender = false;
    var $redirectUrl = array('fail' => 'on purpose');
 
    function redirect($url, $status = null, $exit = true) {
        $this->redirectUrl = $url;
    }
 
    function render($action = null, $layout = null, $file = null) {
        $this->renderedAction = $action;
    }
 
    function _stop($status = 0) {
        $this->stopped = $status;
    }
}

class LessonsControllerTest extends CakeTestCase {
	
	var $courseId = -1;
	
	private $debugLesson = array("id" => -1,
		"course_id" => -1,
		"name" => "Lesson 1: This is the title",
		"main_content" => "main content",
		"lesson_order" => 1);
	
	function startTest() {
		$this->TestLessonsController = new TestLessonsController();
		$this->TestLessonsController->constructClasses();
		$this->TestLessonsController->Component->initialize($this->TestLessonsController);
	}
	
	function endTest() {
		$this->TestLessonsController->Session->destroy();
		unset($this->TestLessonsController);
		ClassRegistry::flush();
	}
	
	// add lesson to course 1
	function testAdd() {
		//setup the data for the request
		$this->TestLessonsController->data = array('Lesson' => $this->debugLesson);
		
		$this->TestLessonsController->params = Router::parse('/Lessons/add');
		$this->TestLessonsController->params['url']['url'] ='/Lessons/add';
		$this->TestLessonsController->beforeFilter();
		
		$this->TestLessonsController->add();
		
		$this->assertEqual($this->TestLessonsController->redirectUrl, array('action'=> 'index'));
	}
	
	function testIndex() {
		$this->TestLessonsController->params = Router::parse('/Lessons/' + $this->courseId);
		$this->TestLessonsController->params['url']['url'] ='/Lessons/' + $this->courseId;
		$this->TestLessonsController->beforeFilter();
		
		$this->TestLessonsController->index($this->courseId);

		if(is_array($this->TestLessonsController->viewVars['lessons'])) {
			$count = count($this->TestLessonsController->viewVars['lessons']);
			$this->assertTrue($count > 0);
		} else  {
			$this->fail('Not an Array');
		}
		
	}
	
	function testEdit() {
		$this->debugLesson['main_content'] = 'alertered content';
		
		$this->TestLessonsController->data = array('Lesson' => $this->debugLesson);
		
		$this->TestLessonsController->params = Router::parse('/Lessons/edit');
		$this->TestLessonsController->params['url']['url'] ='/Lessons/edit';
		$this->TestLessonsController->beforeFilter();
		
		$this->TestLessonsController->edit();
		
		$this->TestLessonsController->Lesson->id = $this->debugLesson['id'];
		$lesson = $this->TestLessonsController->Lesson->read();
		
		$this->assertEqual($lesson['Lesson']['main_content'], $this->debugLesson['main_content']);
		
		
	}
	
	function testDelete() {
		$this->TestLessonsController->params = Router::parse('/Lessons/delete');
		$this->TestLessonsController->params['url']['url'] ='/Lessons/delete';
		$this->TestLessonsController->beforeFilter();
		
		$this->TestLessonsController->delete($this->debugLesson['id']);
		
		$this->assertEqual($this->TestLessonsController->redirectUrl, array('action'=> 'index'));
	}
	
}
?>
