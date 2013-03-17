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
	
	var $testLesson = array('Lesson' => array(
		'id' => -1,
		'course_id' => -1,
		'name' => 'test',
		'main_content' => 'test',
		'lesson_order' => -1
	));
	
	var $testQuiz = array(
		'Quiz' => array(
			'id' => -1,
			'lesson_id' => -1
		),
		'Question' => array(
			array(
				'id' => -1,
				'quiz_id' => -1,
				'type' => 0,
				'points' => 10,
				'question' => 'Please type in \'Two\' to answer the question.',
				'Answer' => 
					array(
						array(
							'id' => -1,
							'question_id' => -1,
							'value' => 'Two',
							'correct' => true
						)
					)
			),
			array(
				'id' => -2,
				'quiz_id' => -1,
				'type' => 1,
				'points' => 15,
				'question' => 'Is this a multiple choice question?',
				'Answer' =>
					array(
						array(
							'id' => -2,
							'question_id' => -2,
							'value' => 'Yes',
							'correct' => true
						),
						array(
							'id' => -3,
							'question_id' => -2,
							'value' => 'No',
							'correct' => false
						)
					)
			),
			array(
				'id' => -3,
				'quiz_id' => -1,
				'type' => 0,
				'points' => 10,
				'question' => 'Is this a fill in the blank?',
				'Answer' =>
					array(
						array(
							'id' => -4,
							'question_id' => -3,
							'value' => 'Yes',
							'correct' => true
						)
					)
			)
		)
	);
	var $testQuizSubmission = array(
		'QuizSubmission' => array(
				array(
				'id' => -1,
				'quiz_id' => -1,
				'user_id' => 1,
				'question_id' => -1,
				'answer' => 'ttwo'),
				array(
				'id' => -2,
				'quiz_id' => -1,
				'user_id' => 1,
				'question_id' => -2,
				'answer' => -2),
				array(
				'id' => -3,
				'quiz_id' => -1,
				'user_id' => 1,
				'question_id' => -3,
				'answer' => 'Yes')
			)
		
	);
	
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
	
	function testTake_Quiz() {
		$this->TestQuizSubmissionsController->Lesson->save($this->testLesson);
		$this->TestQuizSubmissionsController->Quiz->save($this->testQuiz);
		foreach($this->testQuiz['Question'] as $question) {
			$this->TestQuizSubmissionsController->Quiz->Question->saveAll($question);
		}
		
		$this->TestQuizSubmissionsController->QuizSubmission->Behaviors->attach('Containable');
		$this->TestQuizSubmissionsController->data = $this->testQuizSubmission;
		$this->TestQuizSubmissionsController->params = Router::parse('/QuizSubmissions/results');
		$this->TestQuizSubmissionsController->params['url']['url'] ='/QuizSubmissions/results';
		$this->TestQuizSubmissionsController->beforeFilter();
		
		$this->TestQuizSubmissionsController->take_quiz(-1);
		
		$this->assertNotNull($this->TestQuizSubmissionsController->QuizSubmission->find('all', 
			array('conditions' => array('QuizSubmission.quiz_id' => $this->testQuiz['Quiz']['id']))));
			

	}
	
	function testResults(){ 
		$this->TestQuizSubmissionsController->params = Router::parse('/QuizSubmissions/results');
		$this->TestQuizSubmissionsController->params['url']['url'] ='/QuizSubmissions/results';
		$this->TestQuizSubmissionsController->beforeFilter();
		
		$this->TestQuizSubmissionsController->results(10,1);
		$this->assertNotNull($this->TestQuizSubmissionsController->viewVars['results']);
		
		//cleanup
		$this->TestQuizSubmissionsController->QuizSubmission->delete(-1);
		$this->TestQuizSubmissionsController->QuizSubmission->delete(-2);
		$this->TestQuizSubmissionsController->QuizSubmission->delete(-3);
		$this->TestQuizSubmissionsController->Quiz->delete($this->testQuiz['Quiz']['id']);
		$this->TestQuizSubmissionsController->Lesson->delete($this->testLesson['Lesson']['id']);
		
	} 
}
?>
