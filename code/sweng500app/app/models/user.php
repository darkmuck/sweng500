<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: user.php
 * Description: This model provides an abstraction layer for the users database table
 * Created: 2013-02-08
 * Modified: 2013-02-16 13:46
 * Modified By: William DiStefano
*/

class User extends AppModel {

    var $name = 'User';
    
    var $virtualFields = array('name' => "CONCAT(User.first_name, ' ', IFNULL(User.middle_name,''), ' ', User.last_name)");

    var $hasAndBelongsToMany = array(
        'Type' => array(
	    'className' => 'Type',
            'joinTable' => 'types_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'type_id',
            'unique' => true
        )
    );
    
    var $validate = array(); //TO-DO

}
