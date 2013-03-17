<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quizsubmission.php
 * Description: This model provides an abstraction layer for the quizsubmission database table
 * Created: 2013-02-08
 * Modified: 2013-02-13 20:11
 * Modified By: William DiStefano
*/

class QuizSubmission extends AppModel {
	var $actsAs = 'Containable';
	var $recursive = 2;
	var $name = 'QuizSubmission';
	
	var $belongsTo = array('User');

}
