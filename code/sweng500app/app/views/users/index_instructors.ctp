<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: index.php
 * Description: This view provides a listing of users in the database
 * Created: 2013-02-16
 * Modified: 2013-02-16 13:00
 * Modified By: William DiStefano
*/
?>

<div>
    <h2>Users</h2>
    
    <small>
    <strong>&nbsp;Type:  </strong>
    <?php echo $this->Html->link('All', array('action'=>'index')) .'  |  '; ?>
    <?php echo '<strong>'. $this->Html->link('Instructors', array('action'=>'indexInstructors')) .'</strong>  |  '; ?>
    <?php echo $this->Html->link('Students', array('action'=>'indexStudents')) .'  |  '; ?>
    <?php echo $this->Html->link('Administrators', array('action'=>'indexAdministrators')); ?>
    </small>

<table class="table">
    
    <tr>
         <th><?php echo $this->Paginator->sort('last_name'); ?></th>
         <th><?php echo $this->Paginator->sort('first_name'); ?></th>
         <th><?php echo $this->Paginator->sort('username'); ?></th>
         <th><?php echo $this->Paginator->sort('type_id'); ?></th>
         <th><?php echo $this->Paginator->sort('enabled'); ?></th>
         <th>Actions</th>
     </tr> 

    <?php $x=1; foreach ($users as $user) : ?>

    <tr>
        <td><?php echo $user['User']['last_name']; ?></td>
        <td><?php echo $user['User']['first_name']; ?></td>
        <td><?php echo $user['User']['username']; ?></td>
        <td>
            <?php 
                switch ($user['User']['type_id']) {
                    case '1':
                    	    echo 'Administrator';
                    	    break;
                    case '2':
                    	    echo 'Instructor';
                    	    break;
                    case '3':
                    	    echo 'Student';
                    	    break;
                    default:
                    	    echo '-';
                }
            ?>
        </td>
        <td><?php if ($user['User']['enabled'] == '1') { echo 'Yes'; } else { echo 'No'; }; ?></td>
        <td><?php 
            echo $html->link('View', array('action' => 'view', $user['User']['id'])); 
            echo "  |  ";
            echo $html->link('Edit', array('action'=>'edit', $user['User']['id']));
            echo "  |  "; 
            echo $html->link('Disable', array('action' => 'disable', $user['User']['id']), null, 'Are you sure you want to disable this person?' ) ?></td>                          
    </tr>

    <?php $x++; endforeach; ?>

</table>

    <div align="center" width="100%">
        <?php echo $this->Paginator->prev('<--  Previous Page');?>
        <?php echo $this->Paginator->numbers();?> | 
        <?php echo $this->Paginator->next('Next Page -->'); ?>
    </div>
</div>
