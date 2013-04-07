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
<?php $this->Html->addCrumb('Rosters', '/rosters/index');?>
<?php $this->Html->addCrumb($course['Course']['course_name']);?>
<head><style>
.bold{ font-weight:bold;}
.color { color: #6699CC;}
.right{ float:right;}
.redlink { color: #FF0000;}
</style></head>

<div>
<h2 class="color">Course Home</h2>
<h4><?php echo $course['Course']['course_name'];?></h4>
<?php if(!empty($course['Quiz']['id'])): ?> 
<p class="right red"><?php echo $this->Html->link('Exit Course', array('controller' => 'courses', 'action'=> './index'),array(), 'Are you sure you want to exit this course?'); ?></p>
<p class="right color">&nbsp&nbsp|&nbsp&nbsp</p>
<p class="right"><?php echo $this->Html->link('Take Course Test', array('controller' => 'quiz_submissions', 'action'=> 'take_quiz', $course['Quiz']['id'])); ?></p>
<p class="right color">&nbsp&nbsp|&nbsp&nbsp</p>
<?php endif; ?>
  <p class="right"><?php echo $this->Html->link('Grades', array('controller' => 'grades', 'action' => 'index', $course['Course']['id'])); ?>
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
        <td><?php if($lesson['LessonStatus']){
                                echo 'Complete';}
                            else {
                                      echo 'Incomplete';}?></td>
         <td><?php echo $this->Form->button('View', array('onClick'=>"location.href='".$this->Html->url(array('controller' => 'lessons', 'action'=>'view',$lesson['Lesson']['id']))."'", 'class'=>'btn btn-info')); ?></td>
    </tr>
    <?php  endforeach; ?>
    <tr><td><br/></td><td><br/></td><td><br/></td></tr>
    <tr><td class="bold">Course Status</td>
    <td class="bold"><?php echo $roster_course['Roster']['completion_status']; ?></td>
    <td><?php if(($status == 'Complete')) {
	echo $this->Html->link('Print Certificate', array('controller' => 'rosters', 'action'=>'printCertificate',$course['Course']['id'])); }?></td>
</table>

    <div align="center" width="100%">
        <?php echo $this->Paginator->prev('<--  Previous Page');?>
        <?php echo $this->Paginator->numbers();?> | 
        <?php echo $this->Paginator->next('Next Page -->'); ?>
    </div>
<div><?php
    	if($next_lesson)  {
	  if ($count_complete > 0) {
        	      echo $this->Form->button('Resume Course', array('onClick'=>"location.href='".$this->Html->url(array('controller' => 'lessons', 'action' => 'view', $next_lesson['Lesson']['id']))."'", 'class'=>'btn btn-primary'));
    	  }
	else {
	echo $this->Form->button('Begin Course', array('onClick'=>"location.href='".$this->Html->url(array('controller' => 'lessons', 'action' => 'view', $next_lesson['Lesson']['id']))."'", 'class'=>'btn btn-primary'));	
              	}
                 }
    ?>
</div>
</div>
