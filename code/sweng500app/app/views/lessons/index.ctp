<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: index.php
 * Description: This view provides a listing of users in the database
 * Created: 2013-02-16
 * Modified: 2013-02-16 2014
 * Modified By: William DiStefano
*/
?>

<div>
    <h2>Lessons For Course <?php echo $course['Course']['course_name']?></h2>
    
    <?php
        echo '<p>'. $this->Form->button('Add Lesson', array('onClick'=>"location.href='".$this->Html->url('/Lessons/add/'.$course['Course']['id'])."'", 'class'=>'btn btn-primary')) .'</p>';
    ?>

<table class="table">
    
    <tr>
         <th><?php echo $this->Paginator->sort('name'); ?></th>
         <th>Actions</th>
     </tr> 

    <?php foreach ($lessons as $lesson) : ?>

    <tr>
        <td><?php echo $lesson['Lesson']['name']; ?></td>
       
        <td>
            <?php 
            echo $this->Form->button('View', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'view',$lesson['Lesson']['id']))."'", 'class'=>'btn btn-info'));
            echo $this->Form->button('Edit', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'edit',$lesson['Lesson']['id']))."'", 'class'=>'btn btn-warning'));
            echo $this->Form->button('Delete', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'delete',$lesson['Lesson']['id']))."'", 'class'=>'btn btn-danger'));
            ?>
        </td>
    </tr>

    <?php  endforeach; ?>

</table>

    <div align="center" width="100%">
        <?php echo $this->Paginator->prev('<--  Previous Page');?>
        <?php echo $this->Paginator->numbers();?> | 
        <?php echo $this->Paginator->next('Next Page -->'); ?>
    </div>
</div>
