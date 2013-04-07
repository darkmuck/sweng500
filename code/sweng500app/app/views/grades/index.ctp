<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: index.ctp
 * Description: 
 * Created: Apr 6, 2013
 * Modified: Apr 6, 2013 11:58:00 AM
 * Modified By: Kevin Scheib
*/
?>

<?php $this->Html->addCrumb('Roster', '/Rosters');?>
<?php $this->Html->addCrumb($course['Course']['course_name'], '/Rosters/index/'.$course['Course']['id']); ?>

<div>
    <h2>Course Grades</h2>
    
    <table class="table">
    
	    <tr>
	         <th>Name</th>
	         <th>Grade</th>
	     </tr> 
	
	    <?php $x=1; foreach ($grades as $grade) : ?>
	
	    <tr>
	        <td><?php echo $grade['Grade']['name']; ?></td>
	        <td><?php echo $grade['Grade']['grade']; ?>%</td>
	    </tr>
	    <?php $x++; endforeach; ?>
	</table>
