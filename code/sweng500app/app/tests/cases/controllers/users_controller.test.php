<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: users_controller.test.php
 * Description: 
 * Created: Feb 9, 2013
 * Modified: Feb 9, 2013 1:23:31 PM
 * Modified By: Kevin Scheib
*/

/*This class is to override some of the functionality that breaks testing of controllers
see http://mark-story.com/posts/view/testing-cakephp-controllers-the-hard-way */

App::import('Controller', 'Users');
class TestUserController extends UsersController {
	var $name = 'Users';
 
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


class UserControllerTest extends CakeTestCase {
	

	public $debugUser = array('id' => -1,

		'username' => 'test2', 
		'password' => '725e854bd3b14a70e56519d844f55564f042cf74',
		'first_name' => 'Tester',
		'middle_name' => '2',
		'last_name' => 'Second',
		'type_id' => 1);
	
	
	function startTest() {
		$this->TestUserController = new TestUserController();
		$this->TestUserController->constructClasses();
		$this->TestUserController->Component->initialize($this->TestUserController);
	}
	
	function endTest() {
		$this->TestUserController->Session->destroy();
		unset($this->TestUserController);
		ClassRegistry::flush();
	}
	
	function testLogin() {
		$this->TestUserController->Auth->data = array ('User' => array('username' => 'tester', 
				'password' => 'b96689421b87d4c93f377eba19b8eb97807e2656'));
		
		$this->TestUserController->data = array('username' => 'tester', 'password' => 'tester');
		
		$this->TestUserController->params = Router::parse('/Users/login');
	    $this->TestUserController->beforeFilter();

	    $this->TestUserController->login();
	    
	    //assert the url
	    $this->assertEqual($this->TestUserController->redirectUrl, array('action' => 'start'));
	}
	
	function testIncorrectLogin() {
		$this->TestUserController->Auth->data = array ('User' => array('username' => 'asdfasd', 
				'password' => 'asdfads'));
		
		$this->TestUserController->data = array('username' => 'asdf', 'password' => 'asdfdsa');
		
		$this->TestUserController->params = Router::parse('/Users/login');
	    $this->TestUserController->beforeFilter();

	    $this->TestUserController->login();
	    
	    //assert the url
	    $this->assertEqual($this->TestUserController->redirectUrl, array('action' => 'start'));
	}
	
	function testLogout() {
		$this->TestUserController->Auth->data = array ('User' => array('username' => 'tester', 
				'password' => 'b96689421b87d4c93f377eba19b8eb97807e2656'));
		$this->TestUserController->data = array('username' => 'asdf', 'password' => 'asdfdsa');
		
		$this->TestUserController->params = Router::parse('/Users/logout');
	    $this->TestUserController->beforeFilter();

	    $this->TestUserController->logout();
	    
	    //assert the url
	    $this->assertEqual($this->TestUserController->redirectUrl, '/start');
	}
	
	function testIndex() {
		$this->TestUserController->params = Router::parse('/Users');
		$this->TestUserController->params['url']['url'] ='/Users';
		$this->TestUserController->beforeFilter();
		
		$this->TestUserController->index();
		$count = count($this->TestUserController->viewVars['users']);
		$this->assertTrue( $count >= 0);
	}
	
	function testIndexStudents() {
		$this->TestUserController->params = Router::parse('/Users/indexStudents');
		$this->TestUserController->params['url']['url'] ='/Users/indexStudents';
		$this->TestUserController->beforeFilter();
		
		$this->TestUserController->indexStudents();
		$count = count($this->TestUserController->viewVars['users']);
		$this->assertTrue( $count >= 0);
	}
	
	function testIndexInstructors() {
		$this->TestUserController->params = Router::parse('/indexInstructors');
		$this->TestUserController->params['url']['url'] ='/Users/indexInstructors';
		$this->TestUserController->Session->write('Auth.User', array(
	        'id' => 1,
	        'username' => 'tester',
    	));
		
		$this->TestUserController->beforeFilter();
		$this->TestUserController->Component->startup($this->TestUserController);
		$this->TestUserController->indexInstructors();
		$count = count($this->TestUserController->viewVars['users']);
		$this->assertTrue( $count >= 0);
	}
	
	function testIndexAdministrators() {
		
		$this->TestUserController->params = Router::parse('/users/indexAdministrators');
		$this->TestUserController->params['url']['url'] ='/Users/indexAdministrators';
		$this->TestUserController->beforeFilter();
		$this->TestUserController->Component->startup($this->TestUserController);
		$this->TestUserController->indexAdministrators();
		$count = count($this->TestUserController->viewVars['users']);
		$this->assertTrue( $count >= 1);
	}
	
	
	
	function testAdd() {
		$this->TestUserController->data = array('User' => $this->debugUser);
		
		$this->TestUserController->params = Router::parse('/Users/add');
		$this->TestUserController->beforeFilter();
		
		$this->TestUserController->add();

		$this->assertEqual($this->TestUserController->redirectUrl, array('action'=> 'index'));
	}
	
	function testViewUser() {
		$id = -1;

		$this->TestUserController->params = Router::parse('/Users/view');
		$this->TestUserController->beforeFilter();
		
		$this->TestUserController->view($id);
		$this->assertEqual($this->TestUserController->viewVars['user']['User']['first_name'], 
			$this->debugUser['first_name']);
	}
	
	function testEdit() {
		
		$this->debugUser['first_name'] = 'TestEdit';
		$this->TestUserController->data = array('User' => $this->debugUser);
		
		$this->TestUserController->params = Router::parse('/Users/edit');
		$this->TestUserController->beforeFilter();
		
		$this->TestUserController->edit();
		

		$this->TestUserController->User->id = -1;

		$user = $this->TestUserController->User->read();
		
		$this->assertEqual($user['User']['first_name'], $this->debugUser['first_name']);
		
		
	}
	
	function testDelete() {

		$id = -1;

		$this->TestUserController->params = Router::parse('/Users/delete');
		$this->TestUserController->beforeFilter();
		
		$this->TestUserController->delete($id);
		$this->TestUserController->User->id = $id;
		$this->assertFalse($this->TestUserController->User->read());
		
	}
	
	
}
?>
