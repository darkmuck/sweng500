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
	
	function __checkPermissions($courseId) {
		$allow = false;
		if(!empty($courseId)) {
			$this->loadModel('Course');
			$course = $this->Course->findById($courseId);
			$allow = $this->Auth->user('type_id') == 2 && 
				$course['Course']['user_id'] == $this->Auth->user('id');
		}
		
		if(!$allow) {
			$this->Session->setFlash('You do not have permissions to this page.');
			$this->redirect(array('controller' => 'Users', 'action' => 'start'));
		}
		
	}
	
	function __canViewLesson($lessonId) {
		$allow = false;
		$this->loadModel('Course');
		
		$lesson = $this->Lesson->findById($lessonId);
		$course = $this->Course->findById($lesson['Lesson']['course_id']);
		
		if($this->Auth->user('type_id') == 2) {
			$allow = $this->Auth->user('id') == $course['Course']['user_id'];
		} else if($this->Auth->user('type_id') == 3) {
			foreach($course['Roster'] as $roster) {
				if(!$allow && $this->Auth->user('id') == $roster['user_id']) {
					$allow = true;
				}
			}
		}
		
		if(!$allow) {
			$this->Session->setFlash('You do not have permission to view this lesson.');
			$this->redirect(array('controller' => 'Users', 'action' => 'start'));
		}
		
	}
	
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
			$this->__checkPermissions($this->data['Lesson']['course_id']);
			if($this->Lesson->save($this->data)) {
				$this->Session->setFlash('New Lesson has been added');
				$this->redirect(array('action' => 'index', $this->data['Lesson']['course_id']));
			} else {
				$this->Session->setFlash('Error: New Lesson has not been added');
			}
		}else {
			$this->__checkPermissions($courseId);
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
		
		$this->__checkPermissions($this->data['Lesson']['course_id']);
		
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
			//check permissions
			$this->__checkPermissions($lesson['Lesson']['course_id']);
			
			$this->Lesson->delete($lessonId);
			$this->Session->setFlash('Lesson ' + $lessonId + " successfully removed.");
			$this->redirect(array('action' => 'index', $lesson['Lesson']['course_id']));
		}
	}
	
	function view($lessonId = null) {
		$this->__canViewLesson($lessonId);
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
