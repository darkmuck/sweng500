<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quiz.php
 * Description: This model provides an abstraction layer for the quiz database table
 * Created: 2013-02-08
 * Modified: 2013-03-10 14:15
 * Modified By: William DiStefano
*/

class Quiz extends AppModel {
	var $recursive = 2;

    var $name = 'Quiz';
    
    var $hasMany = array('Question');
    var $belongsTo = array('Lesson');
    

}
