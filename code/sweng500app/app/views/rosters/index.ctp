<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: index.ctp
 * Description: This view provides a listing of current student roster of courses (completed courses not included)
 * Created: 2013-02-21
 * Modified: 2013-02-21 
 * Modified By: Dawn Viscuso
*/
?>
<?php $this->Html->addCrumb('Courses', '/Courses/');?>
<?php $this->Html->addCrumb('Roster');?>
<div>
    <h2>Student Roster</h2>
    
    <small>
    <strong>&nbsp;Type:  </strong>
    <?php echo '<strong>' .$this->Html->link('Current', array('action'=>'index')) .' </strong> |  '; ?>
    <?php echo $this->Html->link('All', array('action'=>'./indexHistory')) .'  |  '; ?>

    </small>

<table class="table">
    
    <tr>
         <th><?php echo $this->Paginator->sort('id'); ?></th>
         <th><?php echo $this->Paginator->sort('course_number'); ?></th>
         <th><?php echo $this->Paginator->sort('course_name'); ?></th>
         <th><?php echo $this->Paginator->sort('completion_status'); ?></th>
         <th>Actions</th>
     </tr> 

 <?php $x=1;  foreach ($roster as $roster) : ?>

    <tr>
        <td><?php echo $roster['Roster']['id']; ?></td>
        <td><?php echo $roster['Course']['course_number']; ?></td>
        <td><?php echo $roster['Course']['course_name']; ?></td>        
        <td><?php echo $roster['Roster']['completion_status']; ?></td> 
        <td>
            <?php
            echo $this->Html->link('Launch', array('controller'=> 'Courses', 'action' => 'launch', $roster['Course']['id']), array('class' => 'btn btn-info')); 
            echo $this->Form->button('View', array('onClick'=>"location.href='".$this->Html->url(array('controller' => 'courses', 'action'=>'view',$roster['Course']['id']))."'", 'class'=>'btn btn-info'));
            echo $this->Form->button('Delete', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'delete',$roster['Roster']['id']))."'", 'class'=>'btn btn-danger'));
            ?>
        </td>
    </tr>

    <?php $x++; endforeach; ?>

</table>

    <div align="center" width="100%">
        <?php echo $this->Paginator->prev('<--  Previous Page');?>
        <?php echo $this->Paginator->numbers();?> | 
        <?php echo $this->Paginator->next('Next Page -->'); ?>
    </div>
</div>