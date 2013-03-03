<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: course.php
 * Description: This model provides an abstraction layer for the courses database table
 * Created: 2013-02-22
 * Modified: 2013-02-22 20:20
 * Modified By: David Singer
*/

class Course extends AppModel {

    var $name = 'Course';
    var $hasMany = array(
        'Roster'
    );	
    var $belongsTo = array(
    	'User' => array(
    		'className' => 'User')
    );
	
	var $validate = array(
		'course_number' => array(
			'course_numberNotEmpty' => array(
				'rule' => 'notEmpty', 
				'required' => true, 
				'message' => 'A Course Number is required.',
				'last' => true
			),
			'course_numberMaxLen' => array(
				'rule' => array('maxLength', 6),  
				'message' => 'Course Number maximum length is 6 characters',
				'last' => true
			),
			'course_numberValidChar' => array(
				'rule' => 'alphaNumeric',  
				'message' => 'Only alpha numeric characters may be used.'
			)
		),
		'course_name' => array(
			'course_nameNotEmpty' => array(
				'rule' => 'notEmpty', 
				'required' => true, 
				'message' => 'A Course Name is required.',
				'last' => true
			),
			'course_nameMaxLen' => array(
				'rule' => array('maxLength', 50),  
				'message' => 'Course Name maximum length is 50 characters',
			),
		),
		'lesson_completion' => array(
			'lesson_completionNotEmpty' => array(
				'rule' => 'notEmpty', 
				'required' => true, 
				'message' => 'A Lesson Completion value is required.',
				'last' => true
			),
			'lesson_completionNumeric' => array(
				'rule' => 'numeric', 
				'required' => true, 
				'message' => 'Please enter a number between 0 and 100.',
				'last' => true
			),
			'lesson_completionRange' => array(
				'rule' => array('range', -1, 101),  
				'message' => 'Please enter a number between 0 and 100.',
			)
		),
		'quiz_passing_score' => array(
			'quiz_passing_scoreNotEmpty' => array(
				'rule' => 'notEmpty', 
				'required' => true, 
				'message' => 'A Quiz Passing Score value is required.',
				'last' => true
			),
			'quiz_passing_scoreNumeric' => array(
				'rule' => 'numeric', 
				'required' => true, 
				'message' => 'Please enter a number between 0 and 100.',
				'last' => true
			),
			'quiz_passing_scoreRange' => array(
				'rule' => array('range', -1, 101),  
				'message' => 'Please enter a number between 0 and 100.',
			)
		),
		'course_status' => array(
			'course_statusNotEmpty' => array(
				'rule' => 'notEmpty', 
				'required' => true, 
				'message' => 'A Course Status is required.',
				'last' => true
			),
			'course_statusInList' => array(
				'rule' => array('inList', array('C', 'A', 'U')),  
				'message' => 'Course Status must be either C, A, or U',
			),
		)
    );

	}
	
	
?>