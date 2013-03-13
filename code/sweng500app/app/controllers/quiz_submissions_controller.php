<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quizsubmission_controller.php
 * Description: 
 * Created: Mar 3, 2013
 * Modified: 20130312 19:47
 * Modified By: William DiStefano
*/

class QuizSubmissionsController extends AppController {
	var $name = "QuizSubmissions";
	var $uses = array('QuizSubmission', 'Quiz', 'QuizGrader');
	
	function take_quiz($quizId = null) {
		$this->QuizSubmission->Quiz->Behaviors->attach('Containable'); //helps prevent retrieving the related data
		$quiz = $this->QuizSubmission->Quiz->find('first', array('conditions' => array('id' => $quizId),'contain'=>array()));
		
		if (empty($quiz)) {
			$this->Session->setFlash('Invalid Quiz');
			$this->redirect(array('controller'=>'lessons','index'));
		}
		$this->QuizSubmission->Quiz->Lesson->Behaviors->attach('Containable'); //helps prevent retrieving related data
		$lesson = $this->QuizSubmission->Quiz->Lesson->find('first', array('conditions'=>array('Lesson.id'=>$quiz['Quiz']['lesson_id']), 'contain'=>array()));
		$questions = $this->QuizSubmission->Quiz->Question->find('all', array('conditions' => array('quiz_id' => $quizId)));
		$this->set(compact('quiz','questions','lesson'));
		$this->set('userId',$this->Auth->user('id'));
		
		if (!empty($this->data)) {
			if ($this->QuizSubmission->saveAll($this->data)) {
			    $this->Session->setFlash('Your quiz has been submitted');
			    $this->redirect(array('controller'=>'lessons','action'=>'view',$lesson['Lesson']['id']));
			} else {
			    $this->Session->setFlash('Error, unable to save quiz response');
			    $this->render();
			}
		}
	}
	
	function results($quizSubmissionId = null) {
		$quizsub = $this->QuizSubmission->find('first', 
			array('conditions'=> array('QuizSubmission.id' => 1),
		 		'recursive' => 2)
 		);
 		
 		$quiz = $this->Quiz->findById($quizsub['QuizSubmission']['quiz_id']);
 		
 		debug($this->QuizGrader->grade($quiz, $quizsub));
		

		die(debug($quizsub));
	}
	

}
?>
