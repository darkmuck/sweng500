<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: add.ctp
 * Description: This view adds course data
 * Created: 2013-02-21
 * Modified: 2013-02-21 16:13
 * Modified By: David Singer
*/
?>

<div>
    <h2>New Course</h2>
    
    <?php echo $this->Form->create('Course', array('action'=>'add')); ?>
    <table class="table">
       <tr>
            <td><?php echo $this->Form->input('course_number', array('maxlength'=>'50','label'=>'Course Number'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('course_name', array('maxlength'=>'50','label'=>'Course Name'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('prerequisite', array('maxlength'=>'50','label'=>'Prerequisite'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('lesson_completion', array('maxlength'=>'50','label'=>'Lesson Completion Percentage'));?></td>
        </tr>
		<tr>
            <td><?php echo $this->Form->input('quiz_passing_score', array('maxlength'=>'50','label'=>'Quiz Passing Score Percentage'));?></td>
        </tr>
		<tr>
            <td><?php echo $this->Form->input('instructor', array('maxlength'=>'50','label'=>'Instructor'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('course_status', array('maxlength'=>'50','label'=>'Course Status', 'options'=>array('U'=>'Under Development')));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-success'));?></td>
        </tr>
    </table>
    <?php echo $this->Form->end();?>
</div>
