<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: add.ctp
 * Description: This view provides the inputs for adding a new quiz.
 * Created: 2013-03-10
 * Modified: 2013-03-10 14:56
 * Modified By: William DiStefano
*/
?>
<div>
    <h2>Quiz for <?php echo $lesson['Lesson']['name'] ?></h2>
    
    <table class="table">
    <tr>
        <th>Question</th>
        <th>Answer</th>
    </th>
    	<?php foreach ($questions as $question) {
    	    echo '<tr>
    	              <td>'. $question['Question']['question'] .'
    	              </td>
    	              <td>'. $this->Form->input('QuizSubmission.
    	        </tr>';
    	} ?>
    </table>
    <?php echo $this->Form->end();?>
</div>
