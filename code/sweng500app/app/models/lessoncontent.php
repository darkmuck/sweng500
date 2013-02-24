<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: lessoncontent.php
 * Description: 
 * Created: Feb 23, 2013
 * Modified: Feb 23, 2013 1:40:33 PM
 * Modified By: Kevin Scheib
*/

class LessonContent extends AppModel {

    var $name = 'LessonContent';
    
    public $belongsTo = array('Lesson');
    

}
?>
