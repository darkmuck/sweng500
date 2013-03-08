<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quiz_controller.php
 * Description: 
 * Created: Feb 22, 2013
 * Modified: Feb 22, 2013 1:49:02 PM
 * Modified By: Kevin Scheib
*/

class QuizController extends AppController {
	var $name = 'Quiz';
	var $uses = array('Quiz', 'Question', 'Answer');
	
	function index() {}
	
	//see the test case for the format
	function add($lessonId = null, $courseId = null) {
		if(!empty($this->data)) {	
			$this->Quiz->save($this->data);
			$quizId = $this->Quiz->getLastInsertId();
			foreach($this->data['Quiz']['Question'] as $question) {
				$question['quiz_id'] = $quizId;
				$this->Question->saveAll($question);
			}
		} else {
			$this->set('lessonId', $lessonId);
			$this->set('courseId', $courseId);
		}
		
		
	}
	
	function edit($quizId = null) {
		$quiz = $this->Quiz->find('all', array('conditions' => array('quiz.id' => $quizId)));
		
		debug($quiz);
	}
	
	function delete($quizId = null) {
		if(!empty($quizId)) {
			$this->Quiz->delete($quizId);
		}
	}
	
	function take($quizId = null) {
		
	}
}

?>
