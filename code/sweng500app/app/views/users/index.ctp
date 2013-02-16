<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: UsersController.php
 * Description: This controller provides request handling for users data
 * Created: 2013-02-08
 * Modified: 2013-02-14 08:45
 * Modified By: William DiStefano
*/
?>

<div>
    <h2>Users</h2>

<table cellpadding="0" cellspacing="0">
    
    <tr>
         <th><?php echo $this->Paginator->sort('last_name'); ?></th>
         <th><?php echo $this->Paginator->sort('first_name'); ?></th>
         <th><?php echo $this->Paginator->sort('username'); ?></th>
         <th><?php echo $this->Paginator->sort('enabled'); ?></th>
         <th>&nbsp;</th>
     </tr> 

    <?php $x=1; foreach ($users as $user) : ?>

    <tr>
        <td><?php echo $user['User']['last_name']; ?></td>
        <td><?php echo $user['User']['first_name']; ?></td>
        <td><?php echo $user['User']['username']; ?></td>
        <td><?php if ($user['User']['enabled'] == 1) { echo 'Yes'; } else { echo 'No'; }; ?></td>
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
