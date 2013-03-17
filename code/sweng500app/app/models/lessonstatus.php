<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: course.php
 * Description: This model provides an abstraction layer for the Bookmark database table
 * Created: 2013-02-08
 * Modified: 2013-02-16 20:20
 * Modified By: Dawn Viscuso
*/

class LessonStatus extends AppModel {

var $name = 'LessonStatus';	

public $belongsTo = array(
        'User', 'Lesson'
    );

var $validate = array( 
                "lesson_id"=>array( 
                        "unique"=>array( 
                                "rule"=>array("checkUnique", array("lesson_id", "user_id")),
                                "message"=>"Lesson already marked as completed!" 
                          )
                  )
 ); 


function checkUnique($data, $fields) { 

                if (!is_array($fields)) { 

                        $fields = array($fields); 

                } 

                foreach($fields as $key) { 

                        $tmp[$key] = $this->data[$this->name][$key]; 

                } 

                if (isset($this->data[$this->name][$this->primaryKey])) { 

                        $tmp[$this->primaryKey] = "<>".$this->data[$this->name][$this->primaryKey]; 
                } 

                return $this->isUnique($tmp, false); 

        } 

 

}
	
	
?>