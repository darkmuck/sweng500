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

App::import('Controller', 'LessonStatuses');
class QuizSubmissionsController extends AppController {
	var $name = "QuizSubmissions";
	var $uses = array('QuizSubmission', 'Quiz', 'QuizGrader', 'Lesson', 'Course', 'Roster', 'Grade');
	
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
		$course = $this->Course->find('first', array('conditions' => array('Course.id' => $quiz['Quiz']['course_id'])));
		$questions = $this->Quiz->Question->find('all', array('conditions' => array('quiz_id' => $quizId)));
		$this->set(compact('quiz','questions','lesson', 'course'));
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
	 		
	 		$course = array();
	 		if(!empty($quiz['Quiz']['lesson_id'])) {
	 			$course = $this->Lesson->findById($quiz['Quiz']['lesson_id']);
	 		} else if (!empty($quiz['Quiz']['course_id'])) {
	 			$course = $this->Course->findById($quiz['Quiz']['course_id']);
	 		}
	 		
	 		
	 		//if the quiz passed update the submissions and show results. 
	 		//If not, redirect back to the lesson page and remove the submission.
	 		
	 		if($quizResult->getPercentage() >= $course['Course']['quiz_passing_score']) {
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
				$this->set('course', $course);
				
				$name = $quiz['Quiz']['name'];
				if(empty($name)) {
					$name = 'Course Test';
				}
				
				$grade = $this->Grade->find('first', array('conditions' => 
					array('course_id' => $course['Course']['id'], 
						'user_id' => $this->Auth->user('id'),
						'name' => $name)
						 ) );
				if(!$grade) 
			    {
			    	$gradeData = array('name' => $name, 
						'user_id' => $this->Auth->user('id'),
						'course_id' => $course['Course']['id'],
						'grade' => $quizResult->getPercentage() );
					$this->Grade->create();
					$this->Grade->save($gradeData);
				}
	 		} else {
	 			$this->QuizSubmission->deleteAll(array('QuizSubmission.quiz_id' => $quizId,
	 				'QuizSubmission.user_id' => $userId));
	 			$this->Session->setFlash('You did not pass the quiz. Please try again');
	 			if(!empty($quiz['Quiz']['lesson_id'])) {
	 				$this->redirect(array('controller'=>'Lessons', 'action' => 'view', 
	 					$quiz['Quiz']['lesson_id']));
	 			} else if (!empty($quiz['Quiz']['course_id'])) {
	 				$this->redirect(array('controller' => 'Courses', 'action' => 'launch',
	 					$quiz['Quiz']['course_id']));
	 			}
	 		}
	 		
	 		//check to see if the lesson is completed if the student is checking their own results.
	 		if(!empty($quiz['Quiz']['lesson_id']) && $this->Auth->user('type_id') == 3) {
	 			//quiz ids that belong to the lesson
	 			$quiz_ids = $this->Quiz->find('all', array('fields' => 'DISTINCT id', 
					'conditions' => 'Quiz.lesson_id = ' . $quiz['Quiz']['lesson_id']));
				$quiz_ids = Set::extract($quiz_ids, '/Quiz/id');
	 			//get completed quiz submission quiz ids
	 			$completed_quizzes = $this->QuizSubmission->find('all', 
	 				array('fields' => 'DISTINCT quiz_id',
	 				'conditions' => array('quiz_id' => $quiz_ids, 
					'user_id' => $this->Auth->user('id'))));
 				$completed_quizzes = Set::Extract($completed_quizzes, '/QuizSubmission/quiz_id');
 				
 				if(array_diff($quiz_ids, $completed_quizzes) == array()) {
 					
 					$lsc = new LessonStatusesController;
 					$lsc->constructClasses();
// 					die(debug($lsc));
 					$lsc->_completeLesson($quiz['Quiz']['lesson_id'], $this->Auth->user('id'));
 					$this->Session->setFlash('Congratulations, you have completed this lesson.');
 				} 
	 			
	 			
	 		} else if (!empty($quiz['Quiz']['course_id']) && $this->Auth->user('type_id') == 3) {
	 			$this->Session->setFlash('Congratulations, you have completed this course.');
	 			// get the roster and set it to complete
	 			$roster = $this->Roster->find('first', 
	 				array('conditions' => 
	 					array(
							'Roster.course_id' => $quiz['Quiz']['course_id'],
							'Roster.user_id' => $this->Auth->user('id')
							)
						)
					);
				$this->Roster->id = $roster['Roster']['id'];
				$this->Roster->saveField("completion_status", "Complete"); 
	 					
	 		}
		} else {
			$this->Session->setFlash('Invalid parameters entered.');
			$this->redirect(array('controller'=>'Users','action'=>'start'));
		}
	}
	

}
?>
