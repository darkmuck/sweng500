<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quizsubmission_controller.test.php
 * Description: 
 * Created: Mar 3, 2013
 * Modified: Mar 3, 2013 1:58:06 PM
 * Modified By: Kevin Scheib
*/

App::import('Controller', 'QuizSubmissions');
class TestQuizSubmissionsController extends QuizSubmissionsController {
	var $name = 'QuizSubmissions';
 
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

class QuizSubmissionsControllerTest extends CakeTestCase {
	var $debugQuizSubmission = array('id' => -1, 'quizId' => -1);
	
	function startTest() {
		$this->TestQuizSubmissionsController = new TestQuizSubmissionsController();
		$this->TestQuizSubmissionsController->constructClasses();
		$this->TestQuizSubmissionsController->Component->initialize($this->TestQuizSubmissionsController);
	}
	
	function endTest() {
		$this->TestQuizSubmissionsController->Session->destroy();
		unset($this->TestQuizSubmissionsController);
		ClassRegistry::flush();
	}
	
	function testSubmit() {
		$this->TestQuizSubmissionsController->data = $this->debugQuizSubmission;
		
		$this->TestQuizSubmissionsController->params = Router::parse('/QuizSubmissions/submit');
		$this->TestQuizSubmissionsController->params['url']['url'] ='/QuizSubmissions/submit';
		$this->TestQuizSubmissionsController->beforeFilter();
		
		$this->TestQuizSubmissionsController->submit();
		
		$this->assertEqual($this->TestQuizSubmissionsController->redirectUrl, array(
			'action'=> 'results', $this->debugQuizSubmission['id']));
	}
	
	function testResults(){ 
		$this->TestQuizSubmissionsController->params = Router::parse('/QuizSubmissions/results');
		$this->TestQuizSubmissionsController->params['url']['url'] ='/QuizSubmissions/results';
		$this->TestQuizSubmissionsController->beforeFilter();
		
		$this->TestQuizSubmissionsController->results($this->debugQuizSubmission['id']);
		
		$this->assertEqual($this->TestQuizSubmissionsController->redirectUrl, array(
			'action'=> 'results', $this->debugQuizSubmission['id']));
	} 
}
?>
