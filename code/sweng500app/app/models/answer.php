<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: answer.php
 * Description: 
 * Created: Mar 5, 2013
 * Modified: Mar 5, 2013 9:36:50 PM
 * Modified By: Kevin Scheib
*/

class Answer extends AppModel {
	var $name = 'Answer';
	
	public $belongsTo = 'Question';
}
?>
