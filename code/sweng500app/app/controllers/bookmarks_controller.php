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

class BookmarksController extends AppController {

var $name = 'Bookmarks';
/*var $uses =array('Bookmark','Lesson');*/


public function index($id=null) {

       $this->Bookmark->Lesson->paginate =  array('conditions' => array(
			'Bookmark.user_id' => $this->Auth->user('id'),
     		'Lesson.course_id' => $id,
          	'Bookmark.bookmark_type' => 'user',
        	'Lesson' => array(
         	'limit' => 10, null, 
        	'order' => array('Lesson.lesson_order' => 'desc')),
       ));

          $bookmark = $this->paginate('Bookmark');
          $this->set('bookmark', $bookmark);
          
               
}

function view($id = null) {
          $this->Bookmark->Lesson->id = $id;
          $lesson = $this->Bookmark->Lesson->read();
          $this->redirect(array('controller' => 'Lessons', 'action'=>'view', $lesson['Lesson']['id']));

    }

function delete($id) {
 
  $this->Bookmark->delete($id);
  $this->Session->setFlash('Bookmark has been deleted!');
  $this->redirect(array('action'=>'./index'));
}

function add($id = null) {
                   $this->Bookmark->create();
                   $this->Bookmark->set(array(
                            'lesson_id' => $id,                   
                            'user_id' => $this->Auth->user('id'),
                            'bookmark_type' => 'user'
                   ));
                  if ($this->Bookmark->validates()) {
                       $this->Bookmark->save($this->data);
                       $this->Session->setFlash('Bookmark has been added!');
                  }
                  else  {
                        $errors = $this->Bookmark->invalidFields();
                        $this->Session->setFlash(implode(',', $errors));
                  }
	$this->redirect($this->referer());


 }

}
?>