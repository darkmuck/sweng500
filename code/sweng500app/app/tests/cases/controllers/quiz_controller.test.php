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
	
	var $debugQuiz = array('lessonId' => -1, 'id' => -1);
		
	function createQuestions($numQuestions = 1) {
		$ret = array('question' => 'Is this a question?', 
			'choices' => array('yes', 'no'),
			'answer' => 'yes');
		$questions = array_fill(0, $numQuestions, $ret);
		
		$this->debugQuiz['questions'] =  $questions;
	}
	
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
		$this->createQuestions(3);
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
		
		$this->assertEqual($this->TestQuizController->redirectUrl, array('controller'=> 'Lessons', 
			'action'=> 'index', $this->debugLesson['id']));
	}
	
	function testEdit() {
		$this->createQuestions(10);
		$this->TestQuizController->data = array('Quiz' => $this->debugQuiz);
		
		$this->TestQuizController->params = Router::parse('/Quiz/edit');
		$this->TestQuizController->params['url']['url'] ='/Quiz/edit';
		$this->TestQuizController->beforeFilter();
		
		$this->TestQuizController->add();
		
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
