<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: launch.ctp
 * Description: This view provides a course main page for a launched course
 * Created: 2013-02-21
 * Modified: 2013-02-24 18:36
*/

?>
<head><style>
.bold{ font-weight:bold;}
.color { color: #6699CC;}
.right{ float:right;}
</style></head>

<div>
<h2 class="color">Course Home</h2>
<h4><?php echo $course['Course']['course_name'];?></h4> 
<p class="right"><?php echo $this->Html->link('Take Course Test', array('controller' => 'courses', 'action'=> 'launch', $course['Course']['id'])); ?></p>
<p class="right color">&nbsp&nbsp|&nbsp&nbsp</p>
  <p class="right"><?php echo $this->Html->link('Bookmarks', array('controller' => 'bookmarks', 'action'=>'index',$course['Course']['id']));?></p>
    

<table class="table">
    
    <tr>
         <th>Lesson Title</th>
         <th>Status</th>
         <th>Actions</th>
     </tr> 

    <?php foreach ($lessons as $lesson) : ?>

    <tr>
        <td><?php echo $this->Html->link($lesson['Lesson']['name'], array('controller'=>'lessons', 'action'=>'view',$lesson['Lesson']['id'])); ?></td>
        <td><?php echo "Status here";?></td>
         <td> <?php echo $this->Form->button('View', array('onClick'=>"location.href='".$this->Html->url(array('controller' => 'lessons', 'action'=>'view',$lesson['Lesson']['id']))."'", 'class'=>'btn btn-info')); ?></td>
    </tr>
    <?php  endforeach; ?>
    <tr><td><br/></td><td><br/></td><td><br/></td></tr>
    <tr><td class="bold">Course Status</td>
    <td class="bold"><?php echo $roster_course['Roster']['completion_status']; ?></td><td></td>
</table>

    <div align="center" width="100%">
        <?php echo $this->Paginator->prev('<--  Previous Page');?>
        <?php echo $this->Paginator->numbers();?> | 
        <?php echo $this->Paginator->next('Next Page -->'); ?>
    </div>
</div>
