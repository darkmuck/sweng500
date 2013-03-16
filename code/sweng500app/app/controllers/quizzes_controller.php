<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quiz_controller.php
 * Description: 
 * Created: Feb 22, 2013
 * Modified: 2013-03-11 21:00
 * Modified By: William DiStefano
*/

class QuizzesController extends AppController {
	var $name = 'Quizzes';
	var $uses = array('Quiz', 'Question', 'Answer', 'Lesson');
	
	function index() {}
	
	function add($lessonId = null, $courseId = null) {

		if(!empty($this->data)) {
			$this->Quiz->save($this->data);
			$quizId = $this->Quiz->getLastInsertId();
			foreach($this->data['Question'] as $question) {
				$question['quiz_id'] = $quizId;
				$this->Question->saveAll($question);
			}
			$this->Session->setFlash('Successfully added quiz');
			$this->redirect(array('controller' => 'lessons', 'action' => 'edit', 
				$this->data['Quiz']['lesson_id']));
		}

		if(!empty($lessonId)) {
			$lesson = $this->Lesson->findById($lessonId);
			$this->data['Quiz']['lesson_id'] = $lesson['Lesson']['id'];
			$this->data['Quiz']['course_id'] = $lesson['Lesson']['course_id'];
			$this->data['Lesson']['name'] = $lesson['Lesson']['name'];
			$this->set('lesson', $lesson);
		}
		$this->set('types', array('Fill in the blank', 'Multiple choice'));

	}
	
	function edit($quizId = null) {
		if(!empty($this->data)) {
			$this->Quiz->save($this->data);
			$quizId = $this->data['Quiz']['id'];
			$this->Question->deleteAll(array('Question.quiz_id' => $quizId), true);
			foreach($this->data['Question'] as $question) {
				if(empty($question['quiz_id'])) {
					$question['quiz_id'] = $quizId;	
				}
				for($i = 0; $i < sizeof($question['Answer']); $i++) {
					if(empty($question['Answer'][$i]['correct'])) {
						$question['Answer'][$i]['correct'] = false;
					}
				}
				$this->Question->saveAll($question);
			}
			$this->Session->setFlash('Successfully edited quiz');
			$this->redirect(array('controller' => 'lessons', 'action' => 'edit', 
				$this->data['Quiz']['lesson_id']));
		} else {
			$quiz = $this->Quiz->findById($quizId);
			$this->data['Quiz'] = $quiz['Quiz'];
			$this->data['Question'] = $quiz['Question'];
			$this->data['Lesson']['name'] = $quiz['Lesson']['name'];
			$this->set('types', array('Fill in the blank', 'Multiple choice'));
		}
		
		
	}
	
	function editAnswers($questionId = null) {
		$question = $this->Quiz->Question->find('first', array('conditions' => array('id' => $questionId)));
		if (empty($question)) {
			$this->Session->setFlash('Invalid Question');
			$this->redirect(array('controller'=>'lessons','index'));
		}

		if (!empty($this->data)) {
		    if ($this->Quiz->Question->Answer->saveAll($this->data['Answer'])) {
			$this->Session->setFlash('The answers have been saved.');
			$this->redirect(array('controller'=>'quizzes','action'=>'editAnswers', $questionId));
		    } else {
			$this->Session->setFlash('Unable to save answers');
			$this->redirect(array('controller'=>'lessons','action'=>'index'));
		    }
		}
			
		$answers = $this->Quiz->Question->Answer->find('all', array('conditions' => array('Answer.question_id' => $questionId)));
		$this->set(compact('question','answers'));
	}
	
	function delete($id = null, $lessonId = null) {
		if(!empty($id) && !empty($lessonId)) {
			$this->Quiz->delete($id);
			$this->Session->setFlash('The quiz has been deleted');
			$this->redirect(array('controller'=>'lessons','action'=>'edit', $lessonId));
		} else {
			$this->Session->setFlash('Invalid Quiz');
			$this->redirect(array('controller'=>'lessons','action'=>'index'));
		}
		
	}
	
	function take($quizId = null) {
		
	}
}

?>
