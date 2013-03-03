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

<div>

    <h2>Search Course Catalog</h2>
    
<?php 
        echo $form->create('Course', array('action'=>'searchResults')); 

        echo $form->input('course_name',array('label'=>'Course Title','type' => 'text')); 
        echo $form->end('Search'); 
?> 
    
</div>
