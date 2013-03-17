<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: bookmarks_controller.test.php
 * Description: 
 * Created: Feb 9, 2013
 * Modified: Feb 28, 2013
 * Modified By: Dawn Viscuso
*/

/*This class is to override some of the functionality that breaks testing of controllers
see http://mark-story.com/posts/view/testing-cakephp-controllers-the-hard-way */

App::import('Controller', 'Bookmarks');
class TestBookmarkController extends BookmarksController {
	var $name = 'Bookmarks';
 
    var $autoRender = false;
 
    function redirect($url, $status = null, $exit = true) {
        $this->redirectUrl = $url;
    }
 
    function render($action = null, $layout = null, $file = null) {
        $this->renderedAction = $action;
    }
 
    function _stop($status = 0) {
        $this->stopped = $status;
    }
}


class BookmarkControllerTest extends CakeTestCase {
	
	public $debugBookmark = array('id' => 5,
		'lesson_id' => 2, 
		'user_id' => 1);
	
	
	function startTest() {
		$this->TestBookmarkController = new TestBookmarkController();
		$this->TestBookmarkController->constructClasses();
		$this->TestBookmarkController->Component->initialize($this->TestBookmarkController);
	}
	
	function endTest() {
		$this->TestBookmarkController->Session->destroy();
		unset($this->TestBookmarkController);
		ClassRegistry::flush();
	}
	
	function testIndex() {
        $id=2;
		$this->TestBookmarkController->params = Router::parse('/Bookmarks');
		$this->TestBookmarkController->params['url']['url'] ='/Bookmarks';
		$this->TestBookmarkController->beforeFilter();

		$this->TestBookmarkController->index($id);
		$count = count($this->TestBookmarkController->viewVars['bookmark']);
		$this->assertTrue( $count >= 0);
	}
	
	function testView() {
		$id = 2;                        
		$this->TestBookmarkController->params = Router::parse('/Bookmarks/view');
		$this->TestBookmarkController->beforeFilter();
		$this->TestBookmarkController->view($id);
		$this->assertEqual(array('controller' => 'Lessons', 'action' => 'view', 
				$this->debugBookmark['lesson_id']), $this->TestBookmarkController->redirectUrl);
	}
	
	function testAdd() {
		$id=2;
		$this->TestBookmarkController->Session->write('Auth.User', array('id' => 1));
		$this->TestBookmarkController->params = Router::parse('/Bookmarks/add');
		$this->TestBookmarkController->beforeFilter();
		$this->TestBookmarkController->add($id);
		$this->addedId = $this->TestBookmarkController->Bookmark->getLastInsertId();
		$count=$this->TestBookmarkController->Bookmark->find('count', array(
             'conditions' => array('Bookmark.lesson_id' => $id,
             'Bookmark.user_id' =>1))); 
		$this->assertTrue($count>0);
	}	
	
	function testDelete() {
		$id = 5;
		$this->TestBookmarkController->params = Router::parse('/Bookmarks/delete');
		$this->TestBookmarkController->beforeFilter();

		$this->TestBookmarkController->delete($this->addedId);
		$this->TestBookmarkController->Bookmark->id = $this->addedId;
		$this->assertFalse($this->TestBookmarkController->Bookmark->read());
	}

	
	
	
}
?>
