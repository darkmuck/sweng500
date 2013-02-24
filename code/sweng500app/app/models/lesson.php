<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: lesson.php
 * Description: 
 * Created: Feb 22, 2013
 * Modified: Feb 22, 2013 1:46:21 PM
 * Modified By: Kevin Scheib
*/

class Lesson extends AppModel {

    var $name = 'Lesson';
    public $hasMany = array('LessonContent');
    

}
?>
