<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: lessons_controller.php
 * Description: 
 * Created: Feb 22, 2013
 * Modified: Feb 22, 2013 1:48:23 PM
 * Modified By: Kevin Scheib
*/

App::import('Controller', 'Lessons');
class TestLessonsController extends LessonsController {
	var $name = 'Lessons';
 
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

class LessonsControllerTest extends CakeTestCase {
	
	function testIndex() {
		
	}
}
?>
