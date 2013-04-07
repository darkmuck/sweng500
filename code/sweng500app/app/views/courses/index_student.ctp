<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: index.ctp
 * Description: This view provides a listing of all courses in the database with options for student to view details
 * Created: 2013-02-21
 * Modified: 2013-02-22 
 * Modified By: Dawn Viscuso
*/
?>
<?php $this->Html->addCrumb('Courses');?>
<div>
    <h2>Course List</h2>
    
    <?php
        echo '<p>'. $this->Form->button('Search Course Catalog', array('onClick'=>"location.href='".$this->Html->url('/courses/search')."'", 'class'=>'btn btn-primary')) .  '&nbsp' . $this->Form->button('View Roster', array('onClick'=>"location.href='".$this->Html->url('/rosters/index')."'", 'class'=>'btn btn-primary')).'</p>';
 
    ?> 
    
    <small>
    <strong>&nbsp;Type:  </strong>
    <?php echo '<strong>'.$this->Html->link('All', array('action'=>'./indexStudent')) .'</strong>  |  '; ?>
    </small>

<table class="table">
    
    <tr>
         <th><?php echo $this->Paginator->sort('id'); ?></th>
         <th><?php echo $this->Paginator->sort('course_number'); ?></th>
         <th><?php echo $this->Paginator->sort('course_name'); ?></th>
         <th><?php echo $this->Paginator->sort('course_status'); ?></th>
         <th>Actions</th>
     </tr> 

    <?php foreach ($courses as $course) : ?>

    <tr>
        <td><?php echo $course['Course']['id']; ?></td>
        <td><?php echo $course['Course']['course_number']; ?></td>
        <td><?php echo $course['Course']['course_name']; ?></td>
		<td><?php 
                switch ($course['Course']['course_status']) {
                    case 'C':
                    	    echo 'Active';
                    	    break;
                    case 'A':
                    	    echo 'Archived';
                    	    break;
                    case 'U':
                    	    echo 'Under Development';
                    	    break;
                    default:
                    	    echo '-';
                }
            ?></td>		
        <td>
            <?php 
            echo $this->Form->button('View', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'view',$course['Course']['id']))."'", 'class'=>'btn btn-info'));
            echo $this->Form->button('Add', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'enroll',$course['Course']['id']))."'", 'class'=>'btn btn-warning'));
            ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

    <div align="center" width="100%">
        <?php echo $this->Paginator->prev('<--  Previous Page');?>
        <?php echo $this->Paginator->numbers();?> | 
        <?php echo $this->Paginator->next('Next Page -->'); ?>
    </div>
</div>