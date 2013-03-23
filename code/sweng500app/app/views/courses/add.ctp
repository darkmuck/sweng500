<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: add.ctp
 * Description: This view adds course data
 * Created: 2013-02-21
 * Modified: 2013-02-24 18:14
 * Modified By: William DiStefano
*/
?>

<?php $this->Html->addCrumb('Courses', '/courses/index');?>
<?php $this->Html->addCrumb('Add Course', '/courses/add');?>

<div>
    <h2>New Course</h2>
    
    <?php echo $this->Form->create('Course', array('action'=>'add'));
		echo $this->Form->hidden('course_status', array('value'=>'U')); ?>
    <table class="table">
       <tr>
            <td><?php echo $this->Form->input('course_number', array('maxlength'=>'50','label'=>'Course Number'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('course_name', array('maxlength'=>'50','label'=>'Course Name'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('course_id', array('empty'=>true,'label'=>'Prerequisite'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('lesson_completion', array('maxlength'=>'50','label'=>'Lesson Completion Percentage'));?></td>
        </tr>
		<tr>
            <td><?php echo $this->Form->input('quiz_passing_score', array('maxlength'=>'50','label'=>'Quiz Passing Score Percentage'));?></td>
        </tr>
		<tr>
            <td><?php echo $this->Form->input('user_id', array('empty'=>true,'label'=>'Instructor'));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-success'));?></td>
        </tr>
    </table>
    <?php echo $this->Form->end();?>
</div>
