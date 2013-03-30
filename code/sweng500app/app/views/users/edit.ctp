<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: UsersController.php
 * Description: This controller provides request handling for users data
 * Created: 2013-02-16
 * Modified: 2013-03-23 11:50
 * Modified By: William DiStefano
*/
?>

<?php
    //Check user type and if we should show certain fields
    $hidden = true;
    if ($Auth['User']['type_id'] == '1') { $hidden = false; } //if administrator then show all fields
?>

<?php $this->Html->addCrumb('Users', '/users/');?>
<?php $this->Html->addCrumb('Edit User ('. $user['User']['name'] .')', '/users/edit/'.$user['User']['id']);?>

<div>
    <h2><?php echo $user['User']['name'];?> </h2>
    
    <?php 
        echo $this->Form->create('User', array('action'=>'edit'));
        echo $this->Form->hidden('id', array('value'=>$user['User']['id']));
        echo $this->Form->hidden('TypeUser.id', array('value'=>$user['TypeUser'][0]['TypesUser']['id']));
        echo $this->Form->hidden('TypeUser.type_id', array('value'=>$user['TypeUser'][0]['TypesUser']['type_id']));
        echo $this->Form->hidden('TypeUser.user_id', array('value'=>$user['TypeUser'][0]['TypesUser']['user_id']));
    ?>
    <table class="table">
                <?php
                    if ($hidden == false) {
                        echo '<tr><td>';
                        echo $this->Form->input('username', array('maxlength'=>'15','label'=>'Username','value'=>$user['User']['username']));
                        echo '</td></tr>';
                    } else {
                        echo $this->Form->hidden('username', array('maxlength'=>'15','label'=>'Username','value'=>$user['User']['username']));
                    }
                ?>
        <tr>
            <td><?php echo $this->Form->input('password', array('maxlength'=>'15','label'=>'Password','value'=>$user['User']['password']));?></td>
        </tr>
                <?php
                    if ($hidden == false) {
                        echo '<tr><td>';
                        echo $this->Form->input('enabled', array('label'=>'Enabled','options'=>array('1'=>'Yes','0'=>'No'), 'default'=>$user['User']['enabled']));
                        echo '</td></tr>';
                    } else {
                        echo $this->Form->hidden('enabled', array('label'=>'Enabled','options'=>array('1'=>'Yes','0'=>'No'), 'default'=>$user['User']['enabled']));
                    }
                ?>
                <?php
                    if ($hidden == false) {
                        echo '<tr><td>';
                        echo $this->Form->input('first_name', array('maxlength'=>'15','label'=>'First Name','value'=>$user['User']['first_name']));
                        echo '</td></tr>';
                    } else {
                        echo $this->Form->hidden('first_name', array('maxlength'=>'15','label'=>'First Name','value'=>$user['User']['first_name']));
                    }
                ?>
                <?php
                    if ($hidden == false) {
                        echo '<tr><td>';
                        echo $this->Form->input('middle_name', array('maxlength'=>'15','label'=>'Middle Name','value'=>$user['User']['middle_name']));
                        echo '</td></tr>';
                    } else {
                        echo $this->Form->hidden('middle_name', array('maxlength'=>'15','label'=>'Middle Name','value'=>$user['User']['middle_name']));
                    }
                ?>
                <?php
                    if ($hidden == false) {
                        echo '<tr><td>';
                        echo $this->Form->input('last_name', array('maxlength'=>'15','label'=>'Last Name','value'=>$user['User']['last_name']));
                        echo '</td></tr>';
                    } else {
                        echo $this->Form->hidden('last_name', array('maxlength'=>'15','label'=>'Last Name','value'=>$user['User']['last_name']));
                    }
                ?>
                <?php
                    if ($hidden == false) {
                        echo '<tr><td>';
                        echo $this->Form->input('type_id', array('maxlength'=>'15','label'=>'Type','options'=>array('1'=>'Administrator','2'=>'Instructor','3'=>'Student'), 'default'=>$user['User']['type_id']));
                        echo '</td></tr>';
                    } else {
                        echo $this->Form->hidden('type_id', array('maxlength'=>'15','label'=>'Type', 'default'=>$user['User']['type_id']));
                    }
                ?>

        <tr>
            <td><?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-success'));?></td>
        </tr>
    </table>
    <?php echo $this->Form->end();?>
</div>
