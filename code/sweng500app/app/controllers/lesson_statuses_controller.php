<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: CoursesController.php
 * Description: This controller provides request handling for course roster data
 * Created: 2013-02-21
 * Modified: 2013-02-22
 * Modified By: Dawn Viscuso
*/

class LessonStatusesController extends AppController {

	var $name = 'LessonStatuses';
	
	function add($id = null) {
		$record = $this->LessonStatus->find('count', array(
			'fields' => 'id',
			'conditions' => array('LessonStatus.user_id' => $this->Auth->user('id'), 
				'LessonStatus.lesson_id' => $id)
		));
		
		if($this->_completeLesson($id, $this->Auth->user('id'))) {
			$this->Session->setFlash('Lesson completed!');
		}
		else{
			/*   $errors = $this->LessonStatus->invalidFields();
			 $this->Session->setFlash(implode(',', $errors));*/
			$this->Session->setFlash('Lesson already completed!');
		}
		$this->redirect($this->referer());
		
	}
	
	function _completeLesson($id, $userId) {
		$record = $this->LessonStatus->find('count', array(
			'fields' => 'id',
			'conditions' => array('LessonStatus.user_id' => $userId, 
				'LessonStatus.lesson_id' => $id)
		));
		
		if($record<1) {
			$this->LessonStatus->create();
			$this->LessonStatus->set(array(
				'lesson_id' => $id,                   
				'user_id' => $userId
			));
			if ($this->LessonStatus->validates()) {
				$this->LessonStatus->save($this->data);
				return true;
			}
		} else {
			return false;
		}
	}
}
?>