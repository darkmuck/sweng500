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

class RostersController extends AppController {

var $name = 'Rosters';
var $uses =array('Roster','Course');


public function index() {

       $this->paginate =  array('conditions' => array('Roster.user_id' => $this->Auth->user('id'),'Roster.completion_status <>' => 'Complete'),
             'Course' => array(
             'limit' => 10, null, 
             'order' => array('Course.course_name' => 'asc'),
       ));

          $roster = $this->paginate('Roster');
          $this->set('roster', $roster);
    
}

public function indexHistory() {

       $this->paginate =  array('conditions' => array('Roster.user_id' => $this->Auth->user('id')),
             'Course' => array(
             'limit' => 10, null, 
             'order' => array('Course.course_name' => 'asc'),
       ));

          $roster = $this->paginate('Roster');
          $this->set('roster', $roster);
    
}


function view($id = null) {
          $this->Course->id = $id;
          $course = $this->Course->read();
          $this->set('roster_course', $course);
    }

function delete($id) {
 
  $this->Roster->delete($id);
  $this->Session->setFlash('Course has been deleted from your roster');
  $this->redirect(array('action'=>'./index'));
}

function complete($id) {

  $this->Roster->id = $id;  
  $this->Roster->saveField("completion_status", "Complete"); 
  $this->redirect($this->referer());
}


}
?>	
	
	
	
	
	
	
	
	
	
	
	
	
	
	