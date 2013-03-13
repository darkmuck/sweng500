<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: take_quiz.ctp
 * Description: This view displays questions, such that a student can take a quiz.
 * Created: 20130312
 * Modified: 20130312 19:47
 * Modified By: William DiStefano
*/
?>

<div>
    <h2>Quiz for <?php echo $lesson['Lesson']['name'] ?></h2>

    <?php echo $this->Form->create('QuizSubmission', array('controller'=>'Quiz_Submissions','action'=>'take_quiz',$quiz['Quiz']['id'])); ?>
    <?php echo $this->Form->input('QuizSubmission.user_id', array('type'=>'hidden','value'=>$userId)); ?>
    <?php echo $this->Form->input('QuizSubmission.quiz_id', array('type'=>'hidden','value'=>$quiz['Quiz']['id'])); ?>
    
    <table class="table">
    <tr>
        <th>Question</th>
        <th>Answer</th>
    </th>
    	<?php foreach ($questions as $question) {
    	    echo '<tr>
    	              <td>'. $question['Question']['question'] .'
    	              </td>
    	              <td>todo</td>
    	        </tr>';
    	} ?>
    </table>

    <?php echo $this->Form->button('Submit', array('type'=>'submit', 'class'=>'btn btn-success')); ?>
    <?php echo $this->Form->end();?>
</div>
