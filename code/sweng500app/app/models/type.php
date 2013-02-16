<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: user.php
 * Description: This model provides an abstraction layer for the users database table
 * Created: 2013-02-08
 * Modified: 2013-02-08 14:37
 * Modified By: William DiStefano
*/

class Type extends AppModel {

    var $name = 'Type';

    var $hasAndBelongsToMany = array(
        'Permission' => array('className' => 'Permission',
            'joinTable' => 'types_permissions',
            'foreignKey' => 'type_id',
            'associationForeignKey' => 'permission_id',
            'unique' => true
        ),
        'User' => array('className' => 'User',
            'joinTable' => 'types_users',
            'foreignKey' => 'type_id',
            'associationForeignKey' => 'user_id',
            'unique' => true
        )
    );
    
    var $validate = array(); //TO-DO

}
