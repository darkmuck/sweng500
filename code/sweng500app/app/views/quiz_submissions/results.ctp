<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: results.ctp
 * Description: 
 * Created: Mar 16, 2013
 * Modified: Mar 16, 2013 4:57:47 PM
 * Modified By: Kevin Scheib
*/

?>
<?php
	$this->Html->addCrumb('Roster', '/Rosters');
	if(!empty($quiz['Quiz']['lesson_id'])) {
		$this->Html->addCrumb($course['Lesson']['name'], '/Lessons/view/'.$quiz['Quiz']['lesson_id']);
	} else {
		$this->Html->addCrumb($course['Course']['course_name'], '/Courses/launch/'.$course['Course']['id']);
	}
?>

<div>
<?php if(!empty($quiz['Quiz']['lesson_id'])): ?>
    <h2>Results of <?php echo $quiz['Quiz']['name']; ?></h2>
<?php else: ?>
	<h2>Results of <?php echo $course['Course']['course_name']; ?> Test</h2>
<?php endif; ?>
	
	<span>
	<?php echo $results->getNumberCorrect(); ?> correct out of 
	<?php echo $results->getNumberOfQuestions(); ?> Questions
	</span>
	<br />
	<span>Grade: <?php echo round($results->getPercentage(), 2); ?>% </span>
	<br />
    
    <table class="table">
    <tr>
        <th>Question</th>
        <th>Correct</th>
    </th>
        <?php $count = 0; ?>
    	<?php
    	    foreach ($quiz['Question'] as $question) {
    	?>
    	    <tr>
              <td><?php echo $question['question']; ?> <br />
              		Answer: 
 		<?php
 				foreach($quizSubmission as $sub) {
 					if($sub['QuizSubmission']['question_id'] == $question['id']) {
 						if($question['type'] == 1) {
 							foreach($question['Answer'] as $answer) {
 								if($answer['id'] == $sub['QuizSubmission']['answer']) {
 									echo $answer['value'];
 								}
 							}
 						} else {
 							echo $sub['QuizSubmission']['answer'];
 						}
 					}
 				}
		?>   	
	               
              </td>
	          <td>
        		<?php
        			if($results->answerRubric[$question['id']]) {
        				echo 'Correct: '. $results->points[$question['id']] . ' points';
        			} else {
        				echo 'Incorrect: 0 points';
        			}
    			?>
	          </td>
        	</tr>
        <?php
            $count++;
    	    } 
    	?>
    </table>
    
    
    <?php 
    	if(!empty($quiz['Quiz']['lesson_id'])) {
	    	echo $this->Html->link('Return to Lesson', 
	    		array('controller' => 'lessons', 'action' => 'view', $quiz['Quiz']['lesson_id']));
    	} else {
    		echo $this->Html->link('Return to Course',
    			array('controller' => 'Courses', 'action' => 'launch', $quiz['Quiz']['course_id']));
    	}
	?>

</div>