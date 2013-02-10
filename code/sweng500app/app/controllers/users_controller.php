<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: UsersController.php
 * Description: This controller provides request handling for users data
 * Created: 2013-02-08
 * Modified: 2013-02-08 19:16
 * Modified By: William DiStefano
*/

class UsersController extends AppController {

    var $name = 'Users';
    
    function start() {

    }

    function index() {
        
    }
    
    function view($id = null) {
        
    }
    
    function edit($id = null) {
        
    }
    
    function disable($id = null) {
        
    }
    
    function add () {
        
    }
    
    function login() {
        if (!empty($this->data)) {
            $user = $this->User->find('first',
            	    array('conditions'=>
            	    	array('username'=>$this->Auth->data['User']['username'], 'password'=> $this->Auth->data['User']['password'])
            	    )
            );

            if (!empty($user)) {
                $this->Auth->login($user);	
                $this->Session->delete('Message.auth');
                $this->redirect($this->Auth->redirect());
            }
            $this->redirect(array('action'=>'start'));
        }
    }

    function logout($id = null) {
        $this->Session->delete('Permissions');
        $this->redirect($this->Auth->logout());
    }
}
