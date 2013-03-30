<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: UsersController.php
 * Description: This controller provides request handling for users data
 * Created: 2013-02-16
 * Modified: 2013-02-16 13:30
 * Modified By: William DiStefano
*/
?>
<?php $this->Html->addCrumb('Roster', '/Rosters/');?>
<?php $this->Html->addCrumb($lesson['Course']['course_name'], '/Courses/launch/'. $lesson['Lesson']['course_id']);?>
<head><style>
.color {  color: #6699CC;}
.right {   float:right;}
.padded td { padding: 10px; }
</style></head>

<div>
<?php if(empty($lesson['Bookmark'])): ?>
<p class="right"><?php echo $this->Html->link('Bookmark This Lesson', array('controller' => 'bookmarks', 'action'=> 'add', $lesson['Lesson']['id'])); ?></p>
<?php endif; ?>
<div>
    <h2><?php echo $lesson['Lesson']['name'];?> </h2>
    <hr />
    <b>Main Content:</b> <?php echo $lesson['Lesson']['main_content'] ?><br />
</div>

<?php
	if(!empty($lesson['LessonContent'])):
?>
<div>
	<hr/>
	<p style="font-weight: bold;">Uploaded Supporting Content</p>
	<table class="padded">
<?php foreach($lesson['LessonContent'] as $lc): ?>	
		<tr>
			<td>
				<?php echo $lc['filename']; ?>
			</td>
			<td>
				<?php echo $this->Html->link('Download', 
					array('controller' => 'LessonContents', 'action' => 'download', $lc['id'])); ?>
			</td>
		</tr>
<?php endforeach; ?>
	</table>
</div>
<?php
	endif;
?>

<hr />
<div>
  <?php
  	if($isStudent):
  ?>
  	<p style="font-weight: bold;">Take Quizzes in order to complete lesson</p>
  	<table class="padded">
  		<tr>
  			<th>Quiz Name</th>
  			<th></th>
		</tr>
  <?php
  		foreach($lesson['Quiz'] as $quiz):
  ?>
  		<tr>
  			<td><?php echo $quiz['name']; ?></td>
  			<td>
  				<?php
  					if(!in_array($quiz['id'], $completedQuizzes)) {
	  				    echo $this->Html->link('Take Quiz', 
	  						array('controller' => 'quiz_submissions', 'action' => 'take_quiz', $quiz['id']));
  					} else {
  						echo $this->Html->link('View Results',
  							array('controller' => 'quiz_submissions', 'action' => 'results', $quiz['id'], $Auth['User']['id']));
  					}
				?>
			</td>
		</tr>
				
  <?php
  		endforeach;
  ?>
  	</table>
  <?php
  	endif;
  ?>
	<hr />
  <p class="right"> <?php
  	if($isStudent && sizeof($lesson['Quiz']) == sizeOf($completedQuizzes)) {
 		echo $this->Html->link('Complete Lesson', 
 			array('controller' => 'lesson_statuses', 'action'=> 'add', $lesson['Lesson']['id']));
  	} 
    ?></p>
</div>