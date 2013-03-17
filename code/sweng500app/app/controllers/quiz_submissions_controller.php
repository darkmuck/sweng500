<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quizsubmission_controller.php
 * Description: 
 * Created: Mar 3, 2013
 * Modified: 20130313 20:12
 * Modified By: William DiStefano
*/

class QuizSubmissionsController extends AppController {
	var $name = "QuizSubmissions";
	var $uses = array('QuizSubmission', 'Quiz', 'QuizGrader', 'Lesson');
	
	function take_quiz($quizId = null) {
		$this->Quiz->Behaviors->attach('Containable'); //helps prevent retrieving the related data
		$quiz = $this->Quiz->find('first', array('conditions' => array('id' => $quizId),'contain'=> false));
		
		if (empty($quiz)) {
			$this->Session->setFlash('Invalid Quiz');
			$this->redirect(array('controller'=>'lessons','index'));
		}
		$this->Lesson->Behaviors->attach('Containable'); //helps prevent retrieving related data
		$lesson = $this->Lesson->find('first', array('conditions'=>array('Lesson.id'=>$quiz['Quiz']['lesson_id']), 'contain'=>array()));
		$questions = $this->Quiz->Question->find('all', array('conditions' => array('quiz_id' => $quizId)));
		$this->set(compact('quiz','questions','lesson'));
		$this->set('userId',$this->Auth->user('id'));
		
		if (!empty($this->data)) {
			if ($this->QuizSubmission->saveAll($this->data['QuizSubmission'])) {
			    $this->Session->setFlash('Your quiz has been submitted');
			    $this->redirect(array('action'=>'results',$quiz['Quiz']['id'], $this->Auth->user('id')));
			} else {
			    $this->Session->setFlash('Error, unable to save quiz response');
			    $this->render();
			}
		}
	}
	
	function results($quizId = null, $userId = null) {
		if(!empty($quizId) && !empty($userId)) {
			$quizsub = $this->QuizSubmission->find('all', 
				array('conditions'=> array('QuizSubmission.quiz_id' => $quizId, 
					'QuizSubmission.user_id' => $userId),
					'contain' => false)
	 		);
	 		
	 		$quiz = $this->Quiz->find('first', array('conditions' => array('Quiz.id' => $quizId), 
				'contain' => false));
	 		
	 		$quizResult = $this->QuizGrader->grade($quiz, $quizsub);
			
			foreach($quizsub as $quizSubmission) {
				foreach($quizResult->answerRubric as $key => $correct) {
					if($quizSubmission['QuizSubmission']['question_id'] == $key) {
						$quizSubmission['QuizSubmission']['points'] = 
							$quizResult->points[$quizSubmission['QuizSubmission']['question_id']];
						$this->QuizSubmission->save($quizSubmission);
					}
				}
			}

			$this->set('quizSubmission', $quizsub);
			$this->set('quiz', $quiz);
			$this->set('results', $quizResult);
		} else {
			//error case
		}
	}
	

}
?>
