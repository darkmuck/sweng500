<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: UsersController.php
 * Description: This controller provides request handling for users data
 * Created: 2013-02-16
 * Modified: 2013-02-16 13:46
 * Modified By: William DiStefano
*/
?>

<div>
    <h2><?php echo $user['User']['name'];?> </h2>
    
    <?php 
        echo $this->Form->create('User', array('action'=>'add'));
        echo $this->Form->hidden('id', array('value'=>$user['User']['id']));
    ?>
    <table class="table">
        <tr>
            <td><?php echo $this->Form->input('username', array('maxlength'=>'15','label'=>'Username','value'=>$user['User']['username']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('password', array('maxlength'=>'15','label'=>'Password','value'=>$user['User']['password']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('enabled', array('label'=>'Enabled','options'=>array('1'=>'Yes','0'=>'No'), 'default'=>$user['User']['enabled']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('first_name', array('maxlength'=>'15','label'=>'First Name','value'=>$user['User']['first_name']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('middle_name', array('maxlength'=>'15','label'=>'Middle Name','value'=>$user['User']['middle_name']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('last_name', array('maxlength'=>'15','label'=>'Last Name','value'=>$user['User']['last_name']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('type_id', array('maxlength'=>'15','label'=>'Type','options'=>array('1'=>'Administrator','2'=>'Instructor','3'=>'Student'), 'default'=>$user['User']['type_id']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-success'));?></td>
        </tr>
    </table>
    <?php echo $this->Form->end();?>
</div>
