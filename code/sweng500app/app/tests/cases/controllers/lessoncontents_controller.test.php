<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: lessoncontents_controller.test.php
 * Description: 
 * Created: Feb 23, 2013
 * Modified: Feb 23, 2013 12:42:50 PM
 * Modified By: Kevin Scheib
*/

App::import('Controller', 'LessonContents');
class TestLessonContentsController extends LessonContentsController {
	var $name = 'LessonContents';
 
    var $autoRender = false;
    var $redirectUrl = array('fail' => 'on purpose');
 
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

class LessonContentsControllerTest  extends CakeTestCase {
	

	var $debugFile = array('id'=> -1,
		'lesson_id' => -1,
		'uploadfile' => array('name' => 'eiffeltower.jpg',
			'size' => -1,
			'type' => 'image/jpeg',
			'tmp_name' => './DSCF1743.JPG',
			'error' => 0)
		);
		
				
	function startTest() {
		$this->TestLessonContentsController = new TestLessonContentsController();
		$this->TestLessonContentsController->constructClasses();
		$this->TestLessonContentsController->Component->initialize($this->TestLessonContentsController);
	}
	
	function endTest() {
		$this->TestLessonContentsController->Session->destroy();
		unset($this->TestLessonContentsController);
		ClassRegistry::flush();
	}
	
	function testUpload() {
		$this->TestLessonContentsController->data = array('LessonContent' => $this->debugFile);
		
		$this->TestLessonContentsController->params = Router::parse('/lesson_contents/upload');
		$this->TestLessonContentsController->params['url']['url'] ='/lesson_contents/upload';
		$this->TestLessonContentsController->beforeFilter();
		
		$this->TestLessonContentsController->upload();
		
		$this->assertEqual($this->TestLessonContentsController->redirectUrl, 
			array('controller' => 'Lessons', 'action' => 'edit', $this->debugFile['lesson_id']));
		
		
	}
	
	function testDownload() {
		$fileContents = fread(fopen($this->debugFile['uploadfile']['tmp_name'], "r"), 
				filesize($this->debugFile['uploadfile']['tmp_name']));
				
		$this->TestLessonContentsController->params = Router::parse('/lesson_contents/download');
		$this->TestLessonContentsController->params['url']['url'] ='/lesson_contents/download';
		$this->TestLessonContentsController->beforeFilter();
		
		$this->TestLessonContentsController->download($this->debugFile['id']);
				
		$dbContents = $this->TestLessonContentsController->viewVars['lessonContent'];
		
		$this->assertEqual(stripslashes($dbContents['LessonContent']['content']), $fileContents);
	}
	
	function testDelete() {
		
		$this->TestLessonContentsController->params = Router::parse('/lesson_contents/delete');
		$this->TestLessonContentsController->params['url']['url'] ='/lesson_contents/delete';
		$this->TestLessonContentsController->beforeFilter();
		
		$this->TestLessonContentsController->delete($this->debugFile['id']);
		
		$this->TestLessonContentsController->LessonContent->id = $this->debugFile['id'];
		$this->assertFalse($this->TestLessonContentsController->LessonContent->read());
	}
}

?>
