<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: permission.php
 * Description: This model provides an abstraction layer for the permissions database table
 * Created: 2013-02-08
 * Modified: 2013-02-08 14:00
 * Modified By: William DiStefano
*/

class Permission extends AppModel {

    var $name = 'Permission';

    var $hasAndBelongsToMany = array(
        'Type' => array(
	    'className' => 'Type',
            'joinTable' => 'types_permissions',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'type_id',
            'unique' => true
        )
    );
    
    var $validate = array(); //TO-DO

}
