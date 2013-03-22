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
	
	function add($type = 'Lesson', $id = null) {

		if(!empty($this->data)) {
			$this->Quiz->save($this->data);
			$quizId = $this->Quiz->getLastInsertId();
			foreach($this->data['Question'] as $question) {
				$question['quiz_id'] = $quizId;
				$this->Question->saveAll($question);
			}
			
			if(!empty($this->data['Quiz']['lesson_id'])) {
				$this->Session->setFlash('Successfully added quiz');
				$this->redirect(array('controller' => 'lessons', 'action' => 'edit', 
					$this->data['Quiz']['lesson_id']));
			} else {
				$this->Session->setFlash('Successfully added course test');
				$this->redirect(array('controller' => 'Courses', 'action' => 'index'));
			}
		}

		if($type == 'Lesson' && !empty($id)) {
			$lesson = $this->Lesson->findById($id);
			$this->data['Quiz']['lesson_id'] = $lesson['Lesson']['id'];
			$this->data['Quiz']['course_id'] = NULL;
			$this->data['Lesson']['name'] = $lesson['Lesson']['name'];
			$this->set('lesson', $lesson);
		} else if ($type == 'Course' && !empty($id)) {
			$this->loadModel('Course');
			$course = $this->Course->findById($id);
			$this->data['Quiz']['course_id'] = $course['Course']['id'];
			$this->data['Quiz']['lesson_id'] = NULL;
			$this->data['Course']['course_name'] = $course['Course']['course_name'];
			$this->set('course', $course);
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
			
			if(!empty($this->data['Quiz']['lesson_id'])) {
				$this->Session->setFlash('Successfully edited quiz');
				$this->redirect(array('controller' => 'lessons', 'action' => 'edit', 
					$this->data['Quiz']['lesson_id']));
			} else {
				$this->Session->setFlash('Successfully edited course test');
				$this->redirect(array('controller' => 'Courses', 'action' => 'index'));
			}
		} else {
			$quiz = $this->Quiz->findById($quizId);
			if(!empty($quiz['Quiz']['lesson_id'])) {
				$lesson = $this->Lesson->findById($quiz['Quiz']['lesson_id']);
				$this->data['Lesson']['name'] = $lesson['Lesson']['name'];
			} else {
				$this->loadModel('Course');
				$course = $this->Course->findById($quiz['Quiz']['course_id']);
				$this->data['Course']['course_name'] = $course['Course']['course_name'];
			}
			
			$this->data['Quiz'] = $quiz['Quiz'];
			$this->data['Question'] = $quiz['Question'];
			
			$this->set('types', array('Fill in the blank', 'Multiple choice'));
		}
		
		
	}
	
	
	
	function delete($id = null) {
		if(!empty($id)) {
			$q = $this->Quiz->findById($id);
			$this->Quiz->delete($id);
			if(!empty($q['Quiz']['lesson_id'])) {
				$this->Session->setFlash('The quiz has been deleted');
				$this->redirect(array('controller'=>'lessons','action'=>'edit', 
					$q['Quiz']['lesson_id']));
			} else {
				$this->Session->setFlash('The course test has been deleted');
				$this->redirect(array('controller'=>'Courses','action'=>'index'));
			}
		} else {
			$this->Session->setFlash('Invalid Quiz');
			$this->redirect(array('controller'=>'Courses','action'=>'index'));
		}
		
	}
	
}

?>
