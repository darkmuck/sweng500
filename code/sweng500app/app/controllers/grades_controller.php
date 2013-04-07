<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: grades_controller.php
 * Description: 
 * Created: Apr 5, 2013
 * Modified: Apr 5, 2013 6:56:19 PM
 * Modified By: Kevin Scheib
*/

class GradesController extends AppController {
	
	public $name = 'Grades';
	public $uses = array('Course', 'Grade', 'Roster');
	
	function __checkPermissions($courseId) {
		$allow = false;
		$course = $this->Course->findById($courseId);
		
		if(!$course) {
			$this->Session->setFlash("Course does not exist.");
			$this->redirect(array('controller' => 'courses', 'action' => 'index'));
		}
		
		foreach($course['Roster'] as $roster) {
			if(!$allow && $roster['user_id'] == $this->Auth->user('id')) {
				$allow = true;
			}
		}
		
		if(!$allow) {
			$this->Session->setFlash("You do not have access to this course.");
			$this->redirect(array('controller' => 'courses', 'action' => 'index'));
		}
		
	} 
	
	function index($courseId = null) {
		$this->__checkPermissions($courseId);
		$course = $this->Course->findById($courseId);
		$this->set('course', $course);
		
		$grades = $this->Grade->find('all', 
			array('conditions' => array('user_id' => $this->Auth->user('id'),
				'course_id' => $courseId)
		));
		
		$this->set('grades', $grades);
	}
}

?>
