<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: grades_controller.test.php
 * Description: 
 * Created: Apr 5, 2013
 * Modified: Apr 5, 2013 6:57:21 PM
 * Modified By: Kevin Scheib
*/

App::import('Controller', 'Grades');
class TestGradesController extends GradesController {
	var $name = 'Courses';
 
    var $autoRender = false;
 
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

class GradesControllerTest extends CakeTestCase {
	
	private $debugGrade = array('id' => -1, 
		'user_id' => 1, 
		'course_id' => 1,
		'name' => 'test quiz', 
		'grade' => 90.5);
		
	function startTest() {
		$this->TestGradesController = new TestGradesController();
		$this->TestGradesController->constructClasses();
		$this->TestGradesController->Component->initialize($this->TestGradesController);
	}
	
	function endTest() {
		$this->TestGradesController->Session->destroy();
		unset($this->TestGradesController);
		ClassRegistry::flush();
	}
	
	function testIndex() {
		//preload data
		$this->TestGradesController->Session->write('Auth.User', array(
	        'id' => 1,
	        'username' => 'tester',
    	));
		$this->TestGradesController->Grade->data = $this->debugGrade;
		$this->TestGradesController->Grade->save();
		
		$this->TestGradesController->index($this->debugGrade['course_id']);
		
		$this->assertNotNull($this->TestGradesController->viewVars['grades']);		
	}
}
?>
