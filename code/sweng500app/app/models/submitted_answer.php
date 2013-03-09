<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: submittedanswer.php
 * Description: 
 * Created: Mar 8, 2013
 * Modified: Mar 8, 2013 10:56:22 AM
 * Modified By: Kevin Scheib
*/

class SubmittedAnswer extends AppModel {
	var $actsAs = 'Containable';
	var $name = 'SubmittedAnswer';
	var $belongsTo = array('QuizSubmission', 'Question');

}
?>
