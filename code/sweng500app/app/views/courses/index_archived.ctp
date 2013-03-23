<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: index_archived.ctp
 * Description: This view provides a listing of archived courses in the database
 * Created: 2013-02-21
 * Modified: 2013-02-24 18:37
 * Modified By: David Singer
*/
?>

<?php $this->Html->addCrumb('Courses', '/courses/index');?>
<?php $this->Html->addCrumb('Archived Courses', '/courses/index_archived');?>

<div>
    <h2>Archived Courses</h2>
    
    <?php
    	if($Auth['User']['type_id'] == 1) {
        	echo '<p>'. $this->Form->button('Add Course', array('onClick'=>"location.href='".$this->Html->url('/courses/add')."'", 'class'=>'btn btn-primary')) .'</p>';
    	}
    ?>
    
    <small>
    <strong>&nbsp;Type:  </strong>
    <?php echo '<strong>'.$this->Html->link('All', array('action'=>'./index')) .'</strong>  |  '; ?>
    <?php echo $this->Html->link('Active', array('action'=>'indexCurrent')) .'  |  '; ?>
    <?php echo $this->Html->link('Archived', array('action'=>'indexArchived')) .'  |  '; ?>
    <?php echo $this->Html->link('Under Development', array('action'=>'indexUnderDevelopment')); ?>
    </small>

<table class="table">
    
    <tr>
         <th><?php echo $this->Paginator->sort('id'); ?></th>
         <th><?php echo $this->Paginator->sort('course_number'); ?></th>
         <th><?php echo $this->Paginator->sort('course_name'); ?></th>
         <th><?php echo $this->Paginator->sort('user_id'); ?></th>
         <th><?php echo $this->Paginator->sort('course_status'); ?></th>
         <th>Actions</th>
     </tr> 

    <?php $x=1; foreach ($courses as $course) : ?>

    <tr>
        <td><?php echo $course['Course']['id']; ?></td>
        <td><?php echo $course['Course']['course_number']; ?></td>
        <td><?php echo $course['Course']['course_name']; ?></td>
		<td><?php echo $course['User']['name']; ?></td>		
        <td>
            <?php 
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
            ?>
        </td>        
        <td>
            <?php 
            echo $this->Form->button('View', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'view',$course['Course']['id']))."'", 'class'=>'btn btn-info'));
            if($Auth['User']['id'] == $course['Course']['user_id']) {
            	echo $this->Form->button('Manage Lessons', array('onClick'=>"location.href='".$this->Html->url(array('controller' => 'Lessons','action'=>'index',$course['Course']['id']))."'", 'class'=>'btn btn-info'));
            	if(empty($course['Quiz']['id'])) {
            		echo $this->Html->link('Add Course Test', 
            			array('controller' => 'quizzes', 'action' => 'add', 'Course', $course['Course']['id']),
            			array('class' => 'btn btn-info'));
            	} else {
            		echo $this->Html->link('Edit Course Test', 
            			array('controller' => 'quizzes', 'action' => 'edit', $course['Quiz']['id']),
            			array('class' => 'btn btn-info'));
        			echo $this->Html->link('Delete Course Test', 
        				array('controller' => 'quizzes', 'action' => 'delete', $course['Quiz']['id']), 
        				array('class' => 'btn btn-danger'), 
						'Are you sure you want to delete this course test?');
            	}
            } else if ($Auth['User']['type_id'] == 1) {
	            echo $this->Form->button('Edit', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'edit',$course['Course']['id']))."'", 'class'=>'btn btn-warning'));
	            echo $this->Html->link('Delete', array('controller' => 'courses', 'action' => 'delete', $course['Course']['id']), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this course?');
	        }
            ?>
        </td>
    </tr>

    <?php $x++; endforeach; ?>

</table>

    <div align="center" width="100%">
        <?php echo $this->Paginator->prev('<--  Previous Page');?>
        <?php echo $this->Paginator->numbers();?> | 
        <?php echo $this->Paginator->next('Next Page -->'); ?>
    </div>
</div>
