<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: courses_controller.test.php
 * Description: This file tests the courses controller
 * Created: 2013-02-23
 * Modified: 2013-02-23 18:21
 * Modified By: David Singer
*/

/*This class is to override some of the functionality that breaks testing of controllers
see http://mark-story.com/posts/view/testing-cakephp-controllers-the-hard-way 
see also users_controller.test.php */

App::import('Controller', 'Courses');
class TestCourseController extends CoursesController {
	var $name = 'Courses';
 
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

class CourseControllerTest extends CakeTestCase {

	var $debugCourse = array('id' => 10,
		'course_number' => 'testc1', 
		'course_name' => 'testcourse1',
		'lesson_completion' => 100,
		'quiz_passing_score' => 100,
		'instructor' => 'testinstructor1',
		'course_status' => 'C',
        'course_id' => NULL,
        'user_id' => 1);

	function startTest() {
		$this->TestCourseController = new TestCourseController();
		$this->TestCourseController->constructClasses();
		$this->TestCourseController->Component->initialize($this->TestCourseController);
	}

	function endTest() {
		$this->TestCourseController->Session->destroy();
		unset($this->TestCourseController);
		ClassRegistry::flush();
	}

	function testIndex() {
		$this->TestCourseController->params = Router::parse('/Courses');
		$this->TestCourseController->params['url']['url'] ='/Courses';
		$this->TestCourseController->beforeFilter();

		$this->TestCourseController->index();
		$count = count($this->TestCourseController->viewVars['courses']);
		$this->assertTrue( $count >= 0);
	}

	function testIndexCurrent() {
		$this->TestCourseController->params = Router::parse('/Courses/indexCurrent');
		$this->TestCourseController->params['url']['url'] ='/Courses/indexCurrent';
		$this->TestCourseController->beforeFilter();

		$this->TestCourseController->indexCurrent();
		$count = count($this->TestCourseController->viewVars['courses']);
		$this->assertTrue( $count >= 0);
	}

	function testIndexArchived() {
		$this->TestCourseController->params = Router::parse('/indexArchived');
		$this->TestCourseController->params['url']['url'] ='/Courses/indexArchived';
		$this->TestCourseController->beforeFilter();

		$this->TestCourseController->indexArchived();
		$count = count($this->TestCourseController->viewVars['courses']);
		$this->assertTrue( $count >= 0);
	}

	function testUnderDevelopment() {

		$this->TestCourseController->params = Router::parse('/Courses/indexUnderDevelopment');
		$this->TestCourseController->params['url']['url'] ='/Courses/indexUnderDevelopment';
		$this->TestCourseController->beforeFilter();

		$this->TestCourseController->indexUnderDevelopment();
		$count = count($this->TestCourseController->viewVars['courses']);
		$this->assertTrue( $count >= 1);
	}	

	
	function testAdd() {

		$this->TestCourseController->data = array('Course' => $this->debugCourse);

		$this->TestCourseController->params = Router::parse('/Courses/add');
		$this->TestCourseController->beforeFilter();

		$this->TestCourseController->add();

		$this->assertEqual($this->TestCourseController->redirectUrl, array('action'=> './index')); 
	}



	function testView() {
		$id = 10;
		$this->TestCourseController->params = Router::parse('/Courses/view');
		$this->TestCourseController->beforeFilter();

		$this->TestCourseController->view($id);
		$this->assertEqual($this->TestCourseController->viewVars['course']['Course']['course_number'], 
			$this->debugCourse['course_number']);
	}
	
	function testEdit() {
		$this->debugCourse['course_name'] = 'TestEditCourse';
		$this->TestCourseController->data = array('Course' => $this->debugCourse);

		$this->TestCourseController->params = Router::parse('/Courses/edit');
		$this->TestCourseController->beforeFilter();

		$this->TestCourseController->edit();

		$this->TestCourseController->Course->id = 10;
		$course = $this->TestCourseController->Course->read();

		$this->assertEqual($course['Course']['course_name'], $this->debugCourse['course_name']);
	}


	function testDelete() {
		$id = 10;
		$this->TestCourseController->params = Router::parse('/Courses/delete');
		$this->TestCourseController->beforeFilter();

		$this->TestCourseController->delete($id);
		$this->TestCourseController->Course->id = $id;
		$this->assertFalse($this->TestCourseController->Course->read());
	}
 
	function testEnroll() {
        $id = 3;
        $this->TestCourseController->Session->write('Auth.User', array('id' => 2));
		$this->TestCourseController->params = Router::parse('/Courses/enroll');
		$this->TestCourseController->beforeFilter();
		$this->TestCourseController->enroll($id);   
        $added=$this->TestCourseController->Course->Roster->find('count', array(
             'conditions' => array('Roster.course_id' => $id))); 
		$this->assertTrue($added>0);
	}

	function testSearchResults() { 
  		$this->TestCourseController->data['Course']['course_name'] = 't';
 		$this->TestCourseController->params = Router::parse('/Courses/searchResults');
 		$this->TestCourseController->params['url']['url'] ='/Courses/searchResults';
		$this->TestCourseController->beforeFilter();
		$this->TestCourseController->searchResults(); 
		$count = count($this->TestCourseController->viewVars['courses']);
		$this->assertTrue($count >= 0);
	}
	
	function testArchive() {
		$id = 10;
		$this->TestCourseController->params = Router::parse('/Courses/archive');
		$this->TestCourseController->beforeFilter();
		
		$this->TestCourseController->archive($id);
		$this->assertTrue(file_exists('../models/datasources/archive.zip'));
	}
	
	function testExtract() {
		$id = 6;
		$this->TestCourseController->params = Router::parse('/Courses/archive');
		$this->TestCourseController->beforeFilter();
		
		$this->TestCourseController->extract($id);
		$this->assertFalse(file_exists('../models/datasources/archive6.zip'));
	}
	

}	
?>
