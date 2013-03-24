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
	
	var $validate = array( 
		"course_id"=>array( 
			"unique"=>array( 
				"rule"=>array("checkUnique", array("course_id", "user_id")),
				"message"=>"Course NOT added.  Already in roster!",
				"last" => true
			), 
			"prereqComplete" => array(
				"rule" => array("isEligible", array("course_id", "user_id")),   
				"message" => "Prerequisites have not been met. Request failed!"
			)
		)
	); 
	
	function isEligible($data, $fields ) {
		$prereq_count = 1;

		if (!is_array($fields)) { 
			
			$fields = array($fields);
			
		} 
		$prereq = 0;
		foreach ($fields as $key) { 
			
			$tmp[$key] = $this->data[$this->name][$key]; 
			
			if($key == 'course_id') {   
				$prereq = $this->Course->find('first', array(                            
					'fields' => array('Course.course_id'),                   
					'conditions' => array('Course.id' => $tmp[$key])
					/* 'conditions' => array('Course.id' => 3)*/
				)
				); 
			}
			if (!empty($prereq['Course']['course_id'])) {
				
				if( $key == 'user_id') { 
					
					$prereq_count = $this->Course->Roster->find('count', array(
						
						'conditions' => array('Roster.completion_status' => 'Complete', 'Roster.user_id' => $tmp[$key], 
							/*'Roster.course_id' => 2)*/
							'Roster.course_id' => $prereq['Course']['course_id'])
					)
					);
				}
			}
		} 
		
		return $prereq_count>0; 
	} 
	
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