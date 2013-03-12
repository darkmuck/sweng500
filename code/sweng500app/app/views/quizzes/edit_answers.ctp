<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: add.ctp
 * Description: This view provides the inputs for adding a new quiz.
 * Created: 2013-03-10
 * Modified: 2013-03-11 21:00
 * Modified By: William DiStefano
*/
?>
<div>

    <h2>Question: </h2>
    <?php echo '&nbsp;&nbsp;<i>'. $question['Question']['question'] .'</i>'; ?>
    
    <br />
    
    <h2>Answers: </h2>
    <?php echo $this->Form->button('Add Answer', array('onClick'=>"$('#addAnswer').toggle();", 'class'=>'btn btn-success')); ?>
    
    <div id='addAnswer' style='display:none;border:0.5px solid #333333;margin:10px;padding-top:10px;padding-left:10px; width:250px;'>
    <strong>New Answer:</strong><br />
    <?php echo $this->Form->create('Quiz', array('url'=>'/quizzes/addAnswer')); ?>
    <?php echo $this->Form->hidden('Answer.question_id', array('value'=>$question['Question']['id'])); ?>
    <?php echo $this->Form->input('Answer.correct', array('options'=>array('0'=>'No','1'=>'Yes'), 'label'=>'Correct?'));?>
    <?php echo $this->Form->input('Answer.value', array('maxLength'=>'50','size'=>'10'));?>
    <?php echo $this->Form->button('Submit', array('type'=>'Add','class'=>'btn btn-success'));?>
    <?php echo $this->Form->end(); ?>
    </div>
    <?php 
        echo $this->Form->create('Quiz', array('url' => '/quizzes/editAnswers/'.$question['Question']['id']));
        echo '<table id="answersTable" class="table">';
        foreach ($answers as $key => $answer) {
            echo $this->Form->input('Answer.'. $answer['Answer']['id'] .'.id', array('value' => $answer['Answer']['id'],'type'=>'hidden'));
            echo $this->Form->input('Answer.'. $answer['Answer']['id'] .'.question_id', array('value' => $answer['Answer']['question_id'],'type'=>'hidden'));
            echo '<tr>
                      <td>'. $this->Form->input('Answer.'. $answer['Answer']['id'] .'.correct', array('options'=>array('0'=>'No','1'=>'Yes'),'value' => $answer['Answer']['correct'])) .'</td>
                      <td>'. $this->Form->input('Answer.'. $answer['Answer']['id'] .'.value', array('maxLength'=>'50','size'=>'10','value' => $answer['Answer']['value'])) .'</td>
                      <td>'. $this->Form->button('Delete', array('type'=>'button','onClick'=>"location.href='".$this->Html->url(array('action'=>'deleteAnswer/',$answer['Answer']['id'] .'/'. $question['Question']['id']))."'", 'class'=>'btn btn-danger','style'=>'margin-top:20px;')) .'</td>
                  </tr>';
        }
        echo '</table>';
        echo $this->Form->button('Save Answers', array('type'=>'Add','class'=>'btn btn-success'));
        echo $this->Form->end();
        ?>
