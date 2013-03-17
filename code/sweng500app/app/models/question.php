<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: question.php
 * Description: 
 * Created: Mar 5, 2013
 * Modified: Mar 5, 2013 9:36:08 PM
 * Modified By: Kevin Scheib
*/

class Question extends AppModel {
	var $name = 'Question';
	
	public $hasMany = 'Answer';
}
?>
