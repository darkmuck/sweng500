<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: file.php
 * Description: 
 * Created: Feb 23, 2013
 * Modified: Feb 23, 2013 1:39:27 PM
 * Modified By: Kevin Scheib
*/
?>
<?php $this->Html->addCrumb('Roster', '/Rosters/');?>
<?php $this->Html->addCrumb($lesson['Course']['course_name'], '/Courses/launch/'. $lesson['Lesson']['course_id']);?>
<?php $this->Html->addCrumb($lesson['Lesson']['name'], '/Lessons/view/'. $lesson['Lesson']['id']);?>
<div>
    <h2>Upload Supporting Content for <?php echo $lesson['Lesson']['name']?></h2>
    
    <?php echo $this->Form->create('LessonContent', array('type'=> 'file')); ?>
    <?php echo $this->Form->hidden('lesson_id', array('value'=>$lesson['Lesson']['id'])); ?>
    <table class="table">
        <tr>
            <td><?php echo $this->Form->input('uploadfile', array('type' => 'file', 'maxlength'=>'50','label'=>'File Name'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-success'));?></td>
        </tr>
    </table>
    <?php echo $this->Form->end();?>
</div>
