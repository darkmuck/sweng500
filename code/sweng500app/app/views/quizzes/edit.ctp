<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: add.ctp
 * Description: This view provides the inputs for adding a new quiz.
 * Created: 2013-03-10
 * Modified: 2013-03-10 14:54
 * Modified By: William DiStefano
*/
?>
<div>
    <h2>Quiz for <?php echo $lesson['Lesson']['name'] ?></h2>
    
    <?php echo $this->Form->button('Add Question', array('onClick'=>"$('#addQuestion').toggle();", 'class'=>'btn btn-success')); ?>
    <?php echo $this->Form->button('Delete Quiz', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'delete',$quiz['Quiz']['id'], $quiz['Quiz']['lesson_id']))."'", 'class'=>'btn btn-danger')); ?>
    
    <div id='addQuestion' style='display:none;border:0.5px solid #333333;margin:10px;padding-top:10px;padding-left:10px; width:250px;'>
    <strong>New Question:</strong><br />
    <?php echo $this->Form->create('Quiz', array('url'=>'/quizzes/addQuestion')); ?>
    <?php echo $this->Form->hidden('Question.quiz_id', array('value'=>$quiz['Quiz']['id'])); ?>
    <?php echo $this->Form->input('Question.points', array('maxLength'=>'3'));?>
    <?php echo $this->Form->input('Question.type', array('options'=>array('1'=>'text','2'=>'number','3'=>'date','4'=>'multi-choice')));?>
    <?php echo $this->Form->input('Question.question', array('maxLength'=>'150','type'=>'textarea'));?>
    <?php echo $this->Form->button('Submit', array('type'=>'Add','class'=>'btn btn-success'));?>
    <?php echo $this->Form->end(); ?>
    </div>
    
    <table class="table">
    <tr>
        <th>Points</th>
        <th>Type</th>
        <th>Question</th>
        <th>Actions</th>
    </th>
    	<?php foreach ($questions as $question) {
    	    echo '<tr>
    	              <td>'. $question['Question']['points'] .'</td>
    	              <td>';
    	                  switch ($question['Question']['type']) {
    	                      case '1':
    	                  	  echo 'text';
    	                  	  break;
    	                      case '2':
    	                  	  echo 'number';
    	                  	  break;
    	                      case '3':
    	                  	  echo 'date';
    	                  	  break;
    	                      case '4':
    	                  	  echo 'multi-choice';
    	                  	  break;
    	                      default:
    	                  	  break;
    	                  }
    	        echo '</td>
    	              <td>'. $question['Question']['question'] .'
    	              </td>
    	              <td>';
    	                  echo $this->Form->button('Delete Question', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'deleteQuestion',$question['Question']['id'], $quiz['Quiz']['id']))."'", 'class'=>'btn btn-danger'));
    	                  if ($question['Question']['type'] == '4') { echo '&nbsp;'. $this->Form->button('Edit Answers', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'editAnswers',$question['Question']['id']))."'", 'class'=>'btn btn-success')); }
    	        echo '</td>
    	        </tr>';
    	} ?>
    </table>
    <?php echo $this->Form->end();?>
</div>
