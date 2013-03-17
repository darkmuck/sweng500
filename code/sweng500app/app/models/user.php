<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: user.php
 * Description: This model provides an abstraction layer for the users database table
 * Created: 2013-02-08
 * Modified: 2013-02-16 20:20
 * Modified By: William DiStefano
*/

class User extends AppModel {

    var $name = 'User';
  
    var $virtualFields = array('name' => "CONCAT(User.first_name, ' ', IFNULL(User.middle_name,''), ' ', User.last_name)");
    
    var $hasMany = array(
    	'Course' => array(
    		'className' => 'Course'),
                   'Roster' => array(
                                     'className' => 'Roster'),
                   'Bookmark' => array(
                                     'className' => 'Bookmark')
    );

    var $hasAndBelongsToMany = array(
        'Type' => array(
	    'className' => 'Type',
            'joinTable' => 'types_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'type_id',
            'unique' => true
        )
    );
    
    var $validate = array(
		'username' => array(
			'usernameNotEmpty' => array(
				'rule' => 'notEmpty', 
				'required' => true, 
				'message' => 'A username is required.',
				'last' => true
			),
			'usernameMaxLen' => array(
				'rule' => array('maxLength', 15),  
				'message' => 'First Name maximum length is 15 characters',
				'last' => true
			),
			'usernameValidChar' => array(
				'rule' => 'alphaNumeric',  
				'message' => 'Only alpha numeric characters may be used.'
			)
		),
		'first_name' => array(
			'firstNotEmpty' => array(
				'rule' => 'notEmpty', 
				'required' => true, 
				'message' => 'A first name is required.',
				'last' => true
			),
			'firstMaxLen' => array(
				'rule' => array('maxLength', 20),  
				'message' => 'First Name maximum length is 20 characters',
				'last' => true
			),
			'firstValidChar' => array(
				'rule' => 'alphaNumeric',  
				'message' => 'Only alpha numeric characters may be used.'
			)
		),
		'last_name' => array(
			'lastNotEmpty' => array(
				'rule' => 'notEmpty', 
				'required' => true, 
				'message' => 'A last name is required.',
				'last' => true
			),
			'lastMaxLen' => array(
				'rule' => array('maxLength', 20),  
				'message' => 'Last Name maximum length is 20 characters',
				'last' => true
			),
			'lastValidChar' => array(
				'rule' => 'alphaNumeric',  
				'message' => 'Only alpha numeric characters may be used.'
			)
		),
		'middle_name' => array(
			'middleMaxLen' => array(
				'rule' => array('maxLength', 20),  
				'message' => 'Middle Name maximum length is 20 characters',
				'last' => true
			),
			'middleValidChar' => array(
				'rule' => 'alphaNumeric',  
				'message' => 'Only alpha numeric characters may be used.'
			)
		)
    );

}
