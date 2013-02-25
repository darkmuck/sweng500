<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: edit.ctp
 * Description: This view allows for editing courses data
 * Created: 2013-02-21
 * Modified: 2013-02-24 18:34
 * Modified By: William DiStefano
*/ //die(debug($course));
?>

<div>
    <h2><?php echo $course['Course']['course_name'];?> </h2>
    
    <?php 
        echo $this->Form->create('Course', array('action'=>'edit'));
        echo $this->Form->hidden('id', array('value'=>$course['Course']['id']));
    ?>
    <table class="table">
         <tr>
            <td><?php echo $this->Form->input('course_number', array('maxlength'=>'50','label'=>'Course Number', 'value'=>$course['Course']['course_number']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('course_name', array('maxlength'=>'50','label'=>'Course Name', 'value'=>$course['Course']['course_name']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('course_id', array('empty'=>true,'label'=>'Prerequisite', 'selected' => $course['Course']['course_id']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('lesson_completion', array('maxlength'=>'50','label'=>'Lesson Completion Percentage', 'value'=>$course['Course']['lesson_completion']));?></td>
        </tr>
		<tr>
            <td><?php echo $this->Form->input('quiz_passing_score', array('maxlength'=>'50','label'=>'Quiz Passing Score Percentage', 'value'=>$course['Course']['quiz_passing_score']));?></td>
        </tr>
		<tr>
            <td><?php echo $this->Form->input('user_id', array('empty'=>true,'label'=>'Instructor', 'selected'=>$course['User']['id']));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('course_status', array('maxlength'=>'50','label'=>'Course Status', 'value'=>$course['Course']['course_status'], 'options'=>array('U'=>'Under Development', 'C'=>'Current', 'A'=>'Archived')));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-success'));?></td>
        </tr>
    </table>
    <?php echo $this->Form->end();?>
</div>
