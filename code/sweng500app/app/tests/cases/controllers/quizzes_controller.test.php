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

App::import('Controller', 'Quizzes');
class TestQuizzesController extends QuizzesController {
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
		'Quiz' => array('id' => -2, 'lesson_id' => 2, 'name' => 'debug'), 
		'Question' => 
			array(
				array(
				'question' => 'Is this another multiple choice question?',
				'points' => 10,
				'type' => 1,
				'Answer' => 
					array(
						array(
							'value' => 'Yes',
							'correct' => 1
						),
						array(
							'value' => 'No',
							'correct' => 0
						)
					)	
				),
				array(
				'question' => 'Is this yet another multiple choice question?',
				'points' => 10,
				'type' => 1,
				'Answer' => 
					array(
						array(
							'value' => 'Yes',
							'correct' => 1
						),
						array(
							'value' => 'No',
							'correct' => 0
						)
					)	
				)
			)
		);
	
	function startTest() {
		$this->TestQuizController = new TestQuizzesController();
		$this->TestQuizController->constructClasses();
		$this->TestQuizController->Component->initialize($this->TestQuizController);
	}
	
	function endTest() {
		$this->TestQuizController->Session->destroy();
		unset($this->TestQuizController);
		ClassRegistry::flush();
	}
	
	function testAdd() {		
		$this->TestQuizController->data = $this->debugQuiz;
		
		$this->TestQuizController->params = Router::parse('/Quizzes/add');
		$this->TestQuizController->params['url']['url'] ='/Quizzes/add';
		$this->TestQuizController->beforeFilter();
		
		$this->TestQuizController->add();
		
		if($this->TestQuizController->Quiz->findById($this->debugQuiz['Quiz']['id'])) {
			$this->assertNotNull($this->TestQuizController->Quiz->findById($this->debugQuiz['Quiz']['id']));
		} else {
			$this->fail("Quiz did not save");
		}
		
		$this->assertEqual(array('controller'=> 'lessons', 
			'action'=> 'edit', $this->debugQuiz['Quiz']['lesson_id']), $this->TestQuizController->redirectUrl);
	}
	
	function testEdit() {
		unset($this->debugQuiz['Question'][1]);
		$this->TestQuizController->data = $this->debugQuiz;
		
		$this->TestQuizController->params = Router::parse('/Quizzes/edit');
		$this->TestQuizController->params['url']['url'] ='/Quizzes/edit';
		$this->TestQuizController->beforeFilter();
		
		$this->TestQuizController->edit();
		
		$savedQuiz = $this->TestQuizController->Quiz->findById($this->debugQuiz['Quiz']['id']);
		$this->assertEqual(sizeOf($this->debugQuiz['Question']), sizeof($savedQuiz['Question']));
		
		$this->assertEqual(array('controller'=> 'lessons', 
			'action'=> 'edit', $this->debugQuiz['Quiz']['lesson_id']), $this->TestQuizController->redirectUrl);
	}
	
	function testDelete() {
		$this->TestQuizController->params = Router::parse('/Quizzes/delete');
		$this->TestQuizController->params['url']['url'] ='/Quizzes/delete';
		$this->TestQuizController->beforeFilter();
		
		if(!$this->TestQuizController->Quiz->findById($this->debugQuiz['Quiz']['id'])) {
			$this->fail('Quiz not in database before delete.');
		}
		
		$this->TestQuizController->delete($this->debugQuiz['Quiz']['id'], $this->debugQuiz['Quiz']['lesson_id']);
		
		$this->assertFalse($this->TestQuizController->Quiz->findById($this->debugQuiz['Quiz']['id']));
		
		$this->assertEqual($this->TestQuizController->redirectUrl, array('controller'=> 'lessons', 
			'action'=> 'edit', $this->debugQuiz['Quiz']['lesson_id']));
	}
	
	
	
}
?>
