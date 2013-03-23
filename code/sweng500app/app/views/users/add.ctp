<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: UsersController.php
 * Description: This controller provides request handling for users data
 * Created: 2013-02-16
 * Modified: 2013-02-16 19:38
 * Modified By: William DiStefano
*/
?>

<?php $this->Html->addCrumb('Users', '/users/');?>
<?php $this->Html->addCrumb('Add User', '/users/add');?>

<div>
    <h2>New User</h2>
    
    <?php echo $this->Form->create('User', array('action'=>'add')); ?>
    <table class="table">
        <tr>
            <td><?php echo $this->Form->input('username', array('maxlength'=>'15','label'=>'Username'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('password', array('maxlength'=>'15','label'=>'Password'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('first_name', array('maxlength'=>'15','label'=>'First Name'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('middle_name', array('maxlength'=>'15','label'=>'Middle Name'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('last_name', array('maxlength'=>'15','label'=>'Last Name'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('type_id', array('maxlength'=>'15','label'=>'Type','options'=>array('1'=>'Administrator','2'=>'Instructor','3'=>'Student')));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-success'));?></td>
        </tr>
    </table>
    <?php echo $this->Form->end();?>
</div>
