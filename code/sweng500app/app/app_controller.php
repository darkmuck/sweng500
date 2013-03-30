<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: App Controller
 * Description: This is the base controller class for the app's controllers
 * Created: 2013-02-08
 * Modified: 2013-03-03 15:00
 * Modified By: William DiStefano
*/

class AppController extends Controller {

    var $components = array('Auth', 'Session', 'RequestHandler', 'DebugKit.Toolbar');
    var $helpers = array('Form','Session', 'Html', 'Javascript', 'Ajax');
    
    function beforeFilter() {
        $this->Auth->fields=array('username'=>'username','password'=>'password');
        $this->Auth->allow(array('logout','start','login','register'));
        $this->Auth->loginAction=array('controller'=>'users','action'=>'login');
        $this->Auth->loginRedirect=array('controller' => 'users', 'action' => 'start');
        $this->Auth->logoutAction=array('controller' => 'users', 'action' => 'logout');
	    $this->Auth->logoutRedirect = array('action'=>'start');
        $this->Auth->authorize='controller';
        $this->Auth->userScope=array('User.enabled = 1');
        $this->set('Auth',$this->Auth->user());
    }
    
    function beforeRender() {
        if($this->Auth->user()){
            $controllerList = Configure::listObjects('controller');
            $permittedControllers = array();
            foreach($controllerList as $controllerItem){
                if($controllerItem <> 'App'){
                    if($this->__permitted($controllerItem,'index')){
                        $permittedControllers[] = $controllerItem;
                    }
                }
            }
        }
        $this->set(compact('permittedControllers'));
    }
    
    function isAuthorized(){
        return $this->__permitted($this->name,$this->action);
    }
    
    function __permitted($controllerName,$actionName){
        $controllerName = low($controllerName);
        $actionName = low($actionName);
        if(!$this->Session->check('Permissions')){
            $permissions = array();
            $permissions[]='users:logout';
            App::import('Model', 'User');
            $thisUser = new User;
            $thisType = $thisUser->find(array('User.id'=>$this->Auth->user('id')));
            $thisType = $thisType['TypeUser'][0]['TypesUser'];
            $this->loadModel('Type');
            $thisPermissions = $this->Type->find(array('Type.id'=>$thisType['type_id']));
            $thisPermissions = $thisPermissions['Permission'];
            foreach($thisPermissions as $thisPermission){
                $permissions[]=$thisPermission['permission_name'];
            }
            $this->Session->write('Permissions',$permissions);
        }else{
            $permissions = $this->Session->read('Permissions');
        }

        foreach($permissions as $permission){
            if($permission == '*'){
                return true;
            }
            if($permission == $controllerName.':*'){
                return true;
            }
            if($permission == $controllerName.':'.$actionName){
                return true;
            }
        }
        return false;
    }

}
