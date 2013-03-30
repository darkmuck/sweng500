<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: UsersController.php
 * Description: This controller provides request handling for users data
 * Created: 2013-02-08
 * Modified: 2013-03-30 15:23
 * Modified By: William DiStefano
*/

class UsersController extends AppController {

    var $name = 'Users';
    
    function start()
    {
    	
        //empty
    }    
    
    function about() 
    {
        //empty
    }
    
    function contactus() 
    {
        //empty
    }
    
    function help() 
    {
        //empty
    }
    
    function __checkPermission($action) {
        $allow = false;

    	if (($action) && ($this->Auth->user('type_id'))) {
    		$type = $this->Auth->user('type_id');
    		switch ($action) {
    		    case 'index':
    		    	    if ($type == '1') $allow = true; //Allow Administrator
    		    	    break;
    		    case 'edit':
    		    	     if (in_array($type, array('1','2','3'))) $allow = true; //Allow Administrator, Instructor, or Student
    		    	    break;
    		    case 'add':
    		    	     if ($type == '1') $allow = true; //Allow Administrator
    		    	    break;
    		    case 'view':
    		    	     if ($type == '1') $allow = true; //Allow Administrator
    		    	    break;
    		    case 'delete':
    		    	     if ($type == '1') $allow = true; //Allow Administrator
    		    	    break;
    		    case 'register':
    		    	    $allow = false; //Don't allow a logged in user to access this
    		    	    break;
    		    default:
    		    	    $allow = false; //Deny
    		}
    	} elseif ($action == 'register') {
    		$allow = true; //Allow non-logged persons to access
    	}
    	
    	if ($allow == true) {
    		return;
    	} else {
    	    $this->Session->setFlash('You do not have permission to do this.');
    	    $this->redirect(array('controller'=>'Users','action'=>'start'));
    	}
    }

    function index() {
    	if ($this->__checkPermission('index')); //Check permission
    	
    	
        $this->paginate = array('User' => array('limit' => 10, null, 'order' => array('User.last_name' => 'asc')));

        $users = $this->paginate('User');

        $this->set('users', $users);
    }
    
    function indexStudents() {
    	if ($this->__checkPermission('index')); //Check permission
    	
        $this->paginate = array('User' => array('limit' => 10, null, 'order' => array('User.last_name' => 'asc')));

        $users = $this->paginate('User', array('User.type_id'=>'3'));

        $this->set('users', $users);
    }
    
    function indexInstructors() {
    	if ($this->__checkPermission('index')); //Check permission
    	
        $this->paginate = array('User' => array('limit' => 10, null, 'order' => array('User.last_name' => 'asc')));

        $users = $this->paginate('User', array('User.type_id'=>'2'));

        $this->set('users', $users);
    }
    
    function indexAdministrators() {
    	if ($this->__checkPermission('index')); //Check permission
    	
        $this->paginate = array('User' => array('limit' => 10, null, 'order' => array('User.last_name' => 'asc')));

        $users = $this->paginate('User', array('User.type_id'=>'1'));

        $this->set('users', $users);
    }
    
    function view($id = null) {
    	if ($this->__checkPermission('view')); //Check permission
    	
	$this->User->id = $id;
	$user = $this->User->read();
	$this->set('user', $user);
    }
    
    function edit($id = null) 
    {
    	if ($this->__checkPermission('edit')); //Check permission
    	
	    $this->User->id = $id;
	    $this->User->read();
	    $user = $this->User->data;
	    $this->set('user', $user);
	    if (!empty($this->data)){
		    $this->data['TypeUser'][0]['TypesUser']['type_id'] = $this->data['User']['type_id'];
		    if ($this->User->saveAll($this->data)) 
		    {             
			    $this->Session->setFlash('User Account has been saved');
                //redirect the user to a different page depending on their type
                switch ($this->Auth->user()['User']['type_id']) {
                    case '1':
                        $this->redirect(array('action' => 'index')); 
                        break;
                    case '2':
                        $this->redirect(array('action' => 'start')); 
                        break;
                    case '3':
                        $this->redirect(array('action' => 'start')); 
                        break;
                    default:
                        $this->redirect(array('action' => 'start')); 
                        break;
                }    
			    $this->redirect(array('action' => 'start'));         
		    } else {
			    $this->Session->setFlash('Error: unable to edit user account');
		    }
	    }
    }
    
    function delete($id = null) {
    	if ($this->__checkPermission('delete')); //Check permission
    	
	    $this->User->delete($id);
	    $this->Session->setFlash('User Account has been deleted');
	    $this->redirect(array('action'=>'index'));
    }
    
    function add () 
    {
    	if ($this->__checkPermission('add')); //Check permission
    	
	if (!empty($this->data)){
		$this->data['TypeUser']['type_id'] = $this->data['User']['type_id'];
		if ($this->User->saveAll($this->data))
		{
			$this->Session->setFlash('New user has been added');
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash('Error: New user has not been added');
		}
	}
    }
   
    function register () 
    {
    	if ($this->__checkPermission('register')); //Check permission
    	
	if (!empty($this->data)){
		$this->data['TypeUser']['type_id'] = $this->data['User']['type_id'];
		if ($this->User->saveAll($this->data))
		{
			$this->Session->setFlash('Your account has been created');
			$this->redirect(array('action' => 'start'));
		} else {
			$this->Session->setFlash('Error: Unable to create new account');
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
