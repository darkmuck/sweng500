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
	
	function startTest() {
		$this->TestUserController = new TestUserController();
		$this->TestUserController->constructClasses();
		$this->TestUserController->Component->initialize($this->TestUserController);
	}
	
	function endTest() {
		unset($this->TestUserController);
		ClassRegistry::flush();
	}
	
	function testLogin() {
		$this->TestUserController->Auth->data = array ('User' => array('username' => 'tester', 
				'password' => 'tester'));
		
		$this->TestUserController->data = array('username' => 'tester', 'password' => 'tester');
		
		$this->TestUserController->params = Router::parse('/users/login');
	    $this->TestUserController->beforeFilter();

	    $this->TestUserController->login();
	    
	    //assert the url
	    $this->assertEqual($this->TestUserController->redirectUrl, array('action' => 'start'));
	}
}
?>
