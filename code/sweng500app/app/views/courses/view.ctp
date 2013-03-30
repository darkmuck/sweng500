<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: view.ctp
 * Description: This view is for viewing courses data
 * Created: 2013-02-21
 * Modified: 2013-02-24 18:41
 * Modified By: William DiStefano
*/
?>

<?php $this->Html->addCrumb('Courses', '/courses/index');?>
<?php $this->Html->addCrumb('View Course', '/courses/view/'. $course['Course']['id']);?>

<div>
    <h2><?php echo $course['Course']['course_name'];?> </h2>
    
    <b>Course ID:</b> <?php echo $course['Course']['id'] ?><br />
    <b>Course Number:</b> <?php echo $course['Course']['course_number']; ?><br />
	<b>Course Name:</b> <?php echo $course['Course']['course_name']; ?><br />
	<b>Prerequisite:</b> <?php foreach ($courses as $courseKey => $courseValue) { if ($course['Course']['course_id']==$courseKey) echo $courseValue; } ?><br />
	<b>Lesson Completion Percentage:</b> <?php echo $course['Course']['lesson_completion']; ?><br />
	<b>Quiz Passing Score Percentage:</b> <?php echo $course['Course']['quiz_passing_score']; ?><br />
	<b>Instructor:</b> <?php echo $course['User']['name']; ?><br />
	<b>Course Status:</b>
		<?php
			switch ($course['Course']['course_status']) {
				case 'U':
					echo 'Under Development';
					break;
				case 'C':
					echo 'Active';
					break;
				case 'A':
					echo 'Archived';
					break;
				default:
					break;
			}

		?>



