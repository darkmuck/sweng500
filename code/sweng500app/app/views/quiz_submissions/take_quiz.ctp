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

    <?php echo $this->Form->create('QuizSubmission', array('url'=>'/quiz_submissions/take_quiz/'.$quiz['Quiz']['id']));?>
    
    <table class="table">
    <tr>
        <th>Question</th>
    </th>
        <?php $count = 0; ?>
    	<?php
    	    foreach ($questions as $question) {
    	    echo '<tr>
    	              <td>'. $question['Question']['question'] . '<br />';
    	?>
    	              	<?php echo $this->Form->input('QuizSubmission.'. $count .'.user_id', array('type'=>'hidden','value'=>$userId)); ?>
    	              	<?php echo $this->Form->input('QuizSubmission.'. $count .'.quiz_id', array('type'=>'hidden','value'=>$quiz['Quiz']['id'])); ?>
    	                <?php echo $this->Form->input('QuizSubmission.'. $count .'.question_id', array('type'=>'hidden','value'=>$question['Question']['id'])); ?>
    	                <?php 
    	                    if ($question['Question']['type'] == '1') {
    	                    	$options = array();
    	                    	foreach ($question['Answer'] as $answer) {
    	                    	    $options[$answer['id']] = $answer['value'];	
    	                    	}
    	                    	echo $this->Form->input('QuizSubmission.'. $count .'.answer', array('type' => 'radio', 'options'=>$options,'legend'=>false));
    	                    } else {
    	                    	echo $this->Form->input('QuizSubmission.'. $count .'.answer', array('type'=>'text','size'=>'15','maxLength'=>'50','label'=>false));
    	                    }
    	                ?>
	                  </td>
    	        </tr>
        <?php
            $count++;
    	    } 
    	?>
    </table>

    <?php echo $this->Form->button('Submit', array('type'=>'submit', 'class'=>'btn btn-success')); ?>
    <?php echo $this->Form->button('Clear', array('type'=>'reset', 'class'=>'btn btn-danger')); ?>
    <?php echo $this->Form->end();?>
</div>
