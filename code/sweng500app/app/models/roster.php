<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: course.php
 * Description: This model provides an abstraction layer for the courses database table
 * Created: 2013-02-08
 * Modified: 2013-02-16 20:20
 * Modified By: William DiStefano
*/

class Roster extends AppModel {

var $name = 'Roster';	

public $belongsTo = array(
        'User', 'Course'
    );


/*
var $validate = array(
   'user_id' => array(
      'rule' => array('noDuplicates', 'user_id'),
      'message' => 'Course already in your roster.'
    )
);  
*/
/** 
 * Checks if there are records in Roster with the same userid and courseid
 * 
 */ 
/*
public function noDuplicates ($user_id, $course_id) {
   $count = $this->find('count', array(
      'conditions' => array(
          'user_id' => $user_id 
          'course_id' => $course_id)
   ));
   return $count == 0;

} 
*/

}
	
	
?>