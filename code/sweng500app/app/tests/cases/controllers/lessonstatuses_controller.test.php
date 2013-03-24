<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: lessonstatuses_controller.test.php
 * Description: 
 * Created: Feb 9, 2013
 * Modified: Feb 28, 2013
 * Modified By: Dawn Viscuso
*/

/*This class is to override some of the functionality that breaks testing of controllers
see http://mark-story.com/posts/view/testing-cakephp-controllers-the-hard-way */

App::import('Controller', 'LessonStatuses');
class TestLessonStatusController extends LessonStatusesController {
	var $name = 'LessonStatuses';
 
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


class LessonStatusControllerTest extends CakeTestCase {
	
	public $debugLessonStatus = array('id' => 10,
		'user_id' => 2, 
		'lesson_id' => 4);
	
	
	function startTest() {
		$this->TestLessonStatusController = new TestLessonStatusController();
		$this->TestLessonStatusController->constructClasses();
		$this->TestLessonStatusController->Component->initialize($this->TestLessonStatusController);
	}
	
	function endTest() {
		$this->TestLessonStatusController->Session->destroy();
		unset($this->TestLessonStatusController);
		ClassRegistry::flush();
	}
	
	function testAdd() {
		$id=4;
		$this->TestLessonStatusController->Session->write('Auth.User', array('id' => 2));
		$this->TestLessonStatusController->params = Router::parse('/LessonStatuses/add');
		$this->TestLessonStatusController->beforeFilter();
		$this->TestLessonStatusController->add($id);
		$this->addedId = $this->TestLessonStatusController->LessonStatus->getLastInsertId();
		$count=$this->TestLessonStatusController->LessonStatus->find('count', array(
             'conditions' => array('LessonStatus.lesson_id' => $id,
             'LessonStatus.user_id' =>2))); 
		$this->assertTrue($count>0);
	}	
	
	
	
	
	
}
?>
