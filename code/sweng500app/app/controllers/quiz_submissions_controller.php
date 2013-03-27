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
	var $uses = array('QuizSubmission', 'Quiz', 'QuizGrader', 'Lesson', 'Course');
	
	private function __checkPermissions($action, $quiz) {
		$allow = false;
		$type = $this->Auth->user('type_id');
		
		$courseId = $quiz['Quiz']['course_id'];
		if(!$courseId) {
			$this->Lesson->id = $quiz['Quiz']['lesson_id'];
			$courseId = $this->Lesson->field('course_id');
		}
		
		$course = $this->Course->find('first', array('conditions' => 
			array ('Course.id' => $courseId)));
		
		switch($action) {
			case 'take':
				foreach($course['Roster'] as $roster) {
					if(!$allow && $roster['user_id'] == $this->Auth->user('id')) {
						$allow = true;
					}
				}
				break;
			case 'results':
				foreach($course['Roster'] as $roster) {
					if(!$allow && $roster['user_id'] == $this->Auth->user('id')) {
						$allow = true;
					}
				}
				$allow = $allow || ($this->Auth->user('id') == $course['Course']['id']);
				break;
			default:
				$allow = false;
		}
		
		if(!$allow) {
			$this->Session->setFlash('You do not have permissions to view this page.');
			$this->redirect(array('controller'=>'Users','action'=>'start'));
		}
	}
	
	function take_quiz($quizId = null) {
		$this->Quiz->Behaviors->attach('Containable'); //helps prevent retrieving the related data
		$quiz = $this->Quiz->find('first', array('conditions' => array('id' => $quizId),'contain'=> false));
		
		$this->__checkPermissions('take', $quiz);
		
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
			$quiz = $this->Quiz->find('first', array('conditions' => array('Quiz.id' => $quizId), 
				'contain' => false));
			$this->__checkPermissions('results', $quiz);
			
			$quizsub = $this->QuizSubmission->find('all', 
				array('conditions'=> array('QuizSubmission.quiz_id' => $quizId, 
					'QuizSubmission.user_id' => $userId),
					'contain' => false)
	 		);
	 		
	 		
	 		$quizResult = $this->QuizGrader->grade($quiz, $quizsub);
	 		
	 		$lesson = $this->Lesson->findById($quiz['Quiz']['lesson_id']);
	 		
	 		//if the quiz passed update the submissions and show results. 
	 		//If not, redirect back to the lesson page and remove the submission.
	 		
	 		if($quizResult->getPercentage() >= $lesson['Course']['quiz_passing_score']) {
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
	 			$this->QuizSubmission->deleteAll(array('QuizSubmission.quiz_id' => $quizId,
	 				'QuizSubmission.user_id' => $userId));
	 			$this->Session->setFlash('You did not pass the quiz. Please try again');
	 			$this->redirect(array('controller'=>'Lessons', 'action' => 'view', $lesson['Lesson']['id']));
	 		}
		} else {
			$this->Session->setFlash('Invalid parameters entered.');
			$this->redirect(array('controller'=>'Users','action'=>'start'));
		}
	}
	

}
?>
