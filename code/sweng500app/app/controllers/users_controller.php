<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: UsersController.php
 * Description: This controller provides request handling for users data
 * Created: 2013-02-08
 * Modified: 2013-02-16 13:30
 * Modified By: William DiStefano
*/

class UsersController extends AppController {

    var $name = 'Users';
    
    function start() {
        //user start page
    }

    function index() {
        $this->paginate = array('User' => array('limit' => 10, null, 'order' => array('User.last_name' => 'asc')));

        $users = $this->paginate('User');

        $this->set('users', $users);
    }
    
    function indexStudents() {
        $this->paginate = array('User' => array('limit' => 10, null, 'order' => array('User.last_name' => 'asc')));

        $users = $this->paginate('User', array('User.type_id'=>'3'));

        $this->set('users', $users);
    }
    
    function indexInstructors() {
        $this->paginate = array('User' => array('limit' => 10, null, 'order' => array('User.last_name' => 'asc')));

        $users = $this->paginate('User', array('User.type_id'=>'2'));

        $this->set('users', $users);
    }
    
    function indexAdministrators() {
        $this->paginate = array('User' => array('limit' => 10, null, 'order' => array('User.last_name' => 'asc')));

        $users = $this->paginate('User', array('User.type_id'=>'1'));

        $this->set('users', $users);
    }
    
    function view($id = null) {
	$this->User->id = $id;
	$user = $this->User->read();
	$this->set('user', $user);
    }
    
    function edit($id = null) 
    {
	$this->User->id = $id;
	$this->User->read();
	$user = $this->User->data;
	$this->set('user', $user);
	if (!empty($this->data)){
		if ($this->User->save($this->data)) 
		{             
			$this->Session->setFlash('User has been saved');             
			$this->redirect(array('action' => 'index'));         
		} else {
			$this->Session->setFlash('Error: unable to edit user');
		}
	}
    }
    
    function delete($id = null) {
	$this->User->delete($id);
	$this->Session->setFlash('User has been deleted');
	$this->redirect(array('action'=>'index'));
    }
    
    function add () 
    {
	if (!empty($this->data)){
		if ($this->User->save($this->data))
		{
			$this->Session->setFlash('New user has been added');
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash('Error: New user has not been added');
		}
	}
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
