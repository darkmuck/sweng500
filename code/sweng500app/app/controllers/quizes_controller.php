<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quiz_controller.php
 * Description: 
 * Created: Feb 22, 2013
 * Modified: 2013-03-10 14:55
 * Modified By: William DiStefano
*/

class QuizesController extends AppController {
	var $name = 'Quizes';
	var $uses = array('Quiz', 'Question', 'Answer', 'Lesson');
	
	function index() {}
	
	function add($lessonId = null, $courseId = null) {
		if(!empty($lessonId) && !empty($courseId)) {
			$this->data['Quiz']['lesson_id'] = $lessonId;
			$this->data['Quiz']['course_id'] = $courseId;
			
			$this->Quiz->save($this->data);
			$quizId = $this->Quiz->getLastInsertId();
			$this->redirect(array('controller'=>'quizes','action'=>'edit', $quizId));
		} else {
			$this->Session->setFlash('Error, invalid course or lesson');
			$this->redirect(array('controller'=>'lessons','action'=>'index'));
		}
	}
	
	function addQuestion() {
		if(!empty($this->data)) {
			$this->Quiz->Question->save($this->data);
			$last = $this->Quiz->Question->getLastInsertId();
			$question = $this->Quiz->Question->find('first', array('id'=>$last));
			$this->redirect(array('controller'=>'Quizes','action'=>'edit', $question['Question']['quiz_id']));
		} else {
			$this->Session->setFlash('Error, invalid course or lesson');
			$this->redirect(array('controller'=>'lessons','action'=>'index'));
		}
	}
	
	function edit($quizId = null) {
		$this->Quiz->Behaviors->attach('Containable'); //helps prevent retrieving the related questions, which will be retrieved separately
		$quiz = $this->Quiz->find('first', array('conditions' => array('id' => $quizId),'contain'=>array()));
		if (empty($quiz)) {
			$this->Session->setFlash('Invalid Quiz');
			$this->redirect(array('controller'=>'lessons','index'));
		}
		$this->Quiz->Lesson->Behaviors->attach('Containable'); //helps prevent retrieving related data
		$lesson = $this->Quiz->Lesson->find('first', array('conditions'=>array('Lesson.id'=>$quiz['Quiz']['lesson_id']), 'contain'=>array()));
		$this->Quiz->Question->Behaviors->attach('Containable'); //helps prevent retrieving the related answers, which are not needed here
		$questions = $this->Quiz->Question->find('all', array('conditions' => array('quiz_id' => $quizId),'contain'=>array()));
		$this->set(compact('quiz','questions','lesson'));
		
	}
	
	function delete($id = null, $lessonId = null) {
		if(!empty($id) && !empty($lessonId)) {
			$this->Quiz->Question->delete($id);
			$this->Session->setFlash('The quiz has been deleted');
			$this->redirect(array('controller'=>'lessons','action'=>'edit', $lessonId));
		}
		$this->Session->setFlash('Invalid Quiz');
		$this->redirect(array('controller'=>'lessons','action'=>'index'));
	}
	
	function deleteQuestion($id = null, $quizId = null) {
		if(!empty($id) && !empty($quizId)) {
			$this->Quiz->Question->delete($id);
			$this->Session->setFlash('The question has been deleted');
			$this->redirect(array('controller'=>'quizes','action'=>'edit', $quizId));
		}
		$this->Session->setFlash('Invalid Question');
		$this->redirect(array('controller'=>'lessons','action'=>'index'));
	}
	
	function take($quizId = null) {
		
	}
}

?>
