<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: add.ctp
 * Description: This view creates search form
 * Created: 2013-02-21
 * Modified: 2013-02-21 
 * Modified By: Dawn Viscuso
*/
?>
<?php $this->Html->addCrumb('Courses', '/Courses/');?>
<?php $this->Html->addCrumb('Search Catalog');?>
<div>

    <h2>Search Course Catalog</h2>
    
<?php 
        echo $form->create('Course', array('action'=>'searchResults')); 

        echo $form->input('course_name',array('label'=>'Course Title','type' => 'text')); 
        echo $form->input('course_number',array('label'=>'Course Number','type' => 'text')); 
        echo $form->end('Search'); 
?> 
    
</div>
