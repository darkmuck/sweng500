<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: lesson_controller.php
 * Description: 
 * Created: Feb 22, 2013
 * Modified: Feb 22, 2013 1:49:02 PM
 * Modified By: Kevin Scheib
*/

class LessonsController extends AppController {
	var $name = 'Lessons';
	
	function index($courseId = null) {
		$this->paginate = array('Lesson' => array('conditions'=> array('Lesson.course_id = ' => $courseId),
			 'limit' => 10, null, 'order' => array('Lesson.lesson_order' => 'asc')));

        $lessons = $this->paginate('Lesson');
        
        $this->loadModel('Course');
        $this->Course->id = $courseId;
        $course = $this->Course->read();
        $this->set('course', $course);

        $this->set('lessons', $lessons);
	}
	
	function add($courseId = null) {
		if(!empty($this->data)) {
			if($this->Lesson->save($this->data)) {
				$this->Session->setFlash('New Lesson has been added');
				$this->redirect(array('action' => 'index', $this->data['Lesson']['course_id']));
			} else {
				$this->Session->setFlash('Error: New Lesson has not been added');
			}
		}else {
			$this->loadModel('Course');
			$this->Course->id = $courseId;
	        $course = $this->Course->read();
	        $this->set('course', $course);
	        $this->set('courseId', $courseId);
		}
			
	}
	
	function edit($id = null) {
		$this->Lesson->id = $id;
		$this->Lesson->read();
		$lesson = $this->Lesson->data;
		$this->set('lesson', $lesson);
		
		$this->loadModel('Course');
		$this->Course->id = $this->data['Lesson']['course_id'];
		$course = $this->Course->read();
		$this->set('course', $course);

		if(!empty($this->data)) {
			if($this->Lesson->save($this->data)) {
				$this->Session->setFlash('Lesson has been updated');
				$this->redirect(array('action' => 'index', $this->data['Lesson']['course_id']));
			} else {
				$this->Session->setFlash('Error: Lesson has not been updated');
			}
		}
	}
	
	function delete($lessonId = null) {
		if(!empty($lessonId)) {
			$this->Lesson->id = $lessonId;
			$lesson = $this->Lesson->read();
			$this->Lesson->delete($lessonId);
			$this->Session->setFlash('Lesson ' + $lessonId + " successfully removed.");
			$this->redirect(array('action' => 'index', $lesson['Lesson']['course_id']));
		}
	}
	
	function view($lessonId = null) {
		$this->Lesson->id = $lessonId;
		$lesson = $this->Lesson->read();
		$this->set('lesson', $lesson);
		
		$isStudent = $this->Auth->User('type_id') == 3;
		$this->set('isStudent', $isStudent);
		
		if($isStudent) {
			$this->loadModel('QuizSubmissions');
			$completedQuizzes = array();
			foreach($lesson['Quiz'] as $quiz) {
				$quizSub = $this->QuizSubmissions->find('first', array('conditions' => 
						array('QuizSubmissions.quiz_id' => $quiz['id'], 
							'QuizSubmissions.user_id' => $this->Auth->User('id'))
						));
				if($quizSub) {
					array_push($completedQuizzes, $quiz['id']);
				}
						
			}
			$this->set('completedQuizzes', $completedQuizzes);
		}
		
	}
}

?>
