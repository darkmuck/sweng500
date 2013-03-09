<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quizsubmission_controller.php
 * Description: 
 * Created: Mar 3, 2013
 * Modified: Mar 3, 2013 11:12:44 AM
 * Modified By: Kevin Scheib
*/

class QuizSubmissionsController extends AppController {
	var $name = "QuizSubmissions";
	var $uses = array('QuizSubmission');
	
	function submit($lessonId = null, $courseId = null) {
			
	}
	
	function results($quizSubmissionId = null) {
		$quizsub = $this->QuizSubmission->find('first', 
			array('conditions'=> array('QuizSubmission.id' => 1),
		 		'recursive' => 2)
 		);
		

		die(debug($quizsub));
	}
	

}
?>
