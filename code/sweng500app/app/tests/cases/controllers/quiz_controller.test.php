<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quiz_controller.test.php
 * Description: 
 * Created: Mar 3, 2013
 * Modified: Mar 3, 2013 1:01:34 PM
 * Modified By: Kevin Scheib
*/

App::import('Controller', 'Quiz');
class TestQuizController extends QuizController {
	var $name = 'Quiz';
 
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

class QuizControllerTest extends CakeTestCase {
	
	var $debugQuiz = array(
		'id' => -2, 'lesson_id' => -1, 
		'Question' => 
			array(0 => 
				array(
				'question' => 'Is this another multiple choice question?',
				'points' => 10,
				'type' => 1,
				'Answer' => 
					array(0 =>
						array(
							'value' => 'Yes',
							'correct' => 1
						),
						1 =>
						array(
							'value' => 'No',
							'correct' => 0
						)
					)	
				)
			)
		);
	
	function startTest() {
		$this->TestQuizController = new TestQuizController();
		$this->TestQuizController->constructClasses();
		$this->TestQuizController->Component->initialize($this->TestQuizController);
	}
	
	function endTest() {
		$this->TestQuizController->Session->destroy();
		unset($this->TestQuizController);
		ClassRegistry::flush();
	}
	
	function testAdd() {		
		$this->TestQuizController->data = array('Quiz' => $this->debugQuiz);
		
		$this->TestQuizController->params = Router::parse('/Quiz/add');
		$this->TestQuizController->params['url']['url'] ='/Quiz/add';
		$this->TestQuizController->beforeFilter();
		
		$this->TestQuizController->add();
		
		if($this->TestQuizController->Quiz->findById($this->debugQuiz['id'])) {
			$this->assertNotNull($this->TestQuizController->Quiz->findById($this->debugQuiz['id']));
		} else {
			$this->fail("Quiz did not save");
		}
		
//		$this->assertEqual($this->TestQuizController->redirectUrl, array('controller'=> 'Lessons', 
//			'action'=> 'index', $this->debugLesson['id']));
	}
	
	function testEdit() {
		$this->TestQuizController->data = array('Quiz' => $this->debugQuiz);
		
		$this->TestQuizController->params = Router::parse('/Quiz/edit');
		$this->TestQuizController->params['url']['url'] ='/Quiz/edit';
		$this->TestQuizController->beforeFilter();
		
		$this->TestQuizController->edit();
		
		$savedQuiz = $this->TestQuizController->Quiz->findById($this->debugQuiz['id']);
		$this->assertEqual(sizeof($savedQuiz['questions']), sizeOf($this->debugQuiz['questions']));
		
		$this->assertEqual($this->TestQuizController->redirectUrl, array('controller'=> 'Lessons', 
			'action'=> 'index', $this->debugLesson['id']));
	}
	
	function testDelete() {
		$this->TestQuizController->params = Router::parse('/Quiz/delete');
		$this->TestQuizController->params['url']['url'] ='/Quiz/delete';
		$this->TestQuizController->beforeFilter();
		
		$this->TestQuizController->delete($this->debugQuiz['id']);
		
		$this->assertFalse($this->TestQuizController->Quiz->findById($this->debugQuiz['id']));
		
		$this->assertEqual($this->TestQuizController->redirectUrl, array('controller'=> 'Lessons', 
			'action'=> 'index', $this->debugLesson['id']));
	}
	
	
	
}
?>
