<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: users_controller.test.php
 * Description: 
 * Created: Feb 9, 2013
 * Modified: Feb 9, 2013 1:23:31 PM
 * Modified By: Kevin Scheib
*/

class UserControllerTest extends CakeTestCase {
	function testLogin() {
		$data = array('username' => 'tester', 'password' => 'tester');
		$result = $this->testAction('/users/login', array('method'=> 'post', 
					'return' => 'result', 
					'data' => $data));
		debug($result);
	}
}
?>
