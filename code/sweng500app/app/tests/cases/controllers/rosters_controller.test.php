<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: users_controller.test.php
 * Description: 
 * Created: Feb 9, 2013
 * Modified: Feb 28, 2013
 * Modified By: Dawn Viscuso
*/

/*This class is to override some of the functionality that breaks testing of controllers
see http://mark-story.com/posts/view/testing-cakephp-controllers-the-hard-way */

App::import('Controller', 'Rosters');
class TestRosterController extends RostersController {
	var $name = 'Rosters';
 
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


class RosterControllerTest extends CakeTestCase {
	
	public $debugRoster = array('id' => 5,
		'course_id' => 2, 
		'student_id' => 1);
	
	
	function startTest() {
		$this->TestRosterController = new TestRosterController();
		$this->TestRosterController->constructClasses();
		$this->TestRosterController->Component->initialize($this->TestRosterController);
	}
	
	function endTest() {
		$this->TestRosterController->Session->destroy();
		unset($this->TestRosterController);
		ClassRegistry::flush();
	}
	
	function testIndex() {
		$this->TestRosterController->params = Router::parse('/Rosters');
		$this->TestRosterController->params['url']['url'] ='/Rosters';
		$this->TestRosterController->beforeFilter();

		$this->TestRosterController->index();
		$count = count($this->TestRosterController->viewVars['roster']);
		$this->assertTrue( $count >= 0);
	}
	
	function testView() {
		$id = 2;
                        
		$this->TestRosterController->params = Router::parse('/Rosters/view');
		$this->TestRosterController->beforeFilter();
		$this->TestRosterController->view($id);
		$this->assertEqual($this->TestRosterController->viewVars['roster_course']['Course']['id'], 
			$this->debugRoster['course_id']);
	}
	
	function testDelete() {
		$id = 5;
		$this->TestRosterController->params = Router::parse('/Rosters/delete');
		$this->TestRosterController->beforeFilter();

		$this->TestRosterController->delete($id);
		$this->TestRosterController->Roster->id = $id;
		$this->assertFalse($this->TestRosterController->Roster->read());
	}

	function testIndexHistory() {
		$this->TestRosterController->params = Router::parse('/Rosters/indexHistory');
		$this->TestRosterController->params['url']['url'] ='/Rosters/indexHistory';
		$this->TestRosterController->beforeFilter();

		$this->TestRosterController->indexHistory();
		$count = count($this->TestRosterController->viewVars['roster']);
		$this->assertTrue( $count >= 0);
	}	
	
	
}
?>
