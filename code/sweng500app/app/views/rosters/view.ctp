<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: view.ctp
 * Description: This view is for viewing courses data from the roster page
 * Created: 2013-02-21
 * Modified: 2013-02-21 14:44
 * Modified By: David Singer
*/
?>

<div>
    <h2><?php echo $roster_course['Course']['course_name'];?> </h2>
    
    <b>Course ID:</b> <?php echo $roster_course['Course']['id'] ?><br />
    <b>Course Number:</b> <?php echo $roster_course['Course']['course_number']; ?><br />
	<b>Course Name:</b> <?php echo $roster_course['Course']['course_name']; ?><br />
	<b>Lesson Completion Percentage:</b> <?php echo $roster_course['Course']['lesson_completion']; ?><br />
	<b>Quiz Passing Score Percentage:</b> <?php echo $roster_course['Course']['quiz_passing_score']; ?><br />
	<b>Instructor:</b> <?php echo $roster_course['Course']['instructor']; ?><br />
	<b>Course Status:</b>
		<?php
			switch ($roster_course['Course']['course_status']) {
				case 'U':
					echo 'Under Development';
					break;
				case 'C':
					echo 'Current';
					break;
				case 'A':
					echo 'Archived';
					break;
				default:
					break;
			}
		?>
		
	
    
