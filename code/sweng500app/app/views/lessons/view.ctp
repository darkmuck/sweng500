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
<head><style>
.color {  color: #6699CC;}
.right {   float:right;}
</style></head>
<div>
<p class="right"><?php echo $this->Html->link('Bookmark This Lesson', array('controller' => 'bookmarks', 'action'=> 'add', $lesson['Lesson']['id'])); ?></p>
<div>
    <h2><?php echo $lesson['Lesson']['name'];?> </h2>
    <hr />
    <b>Main Content:</b> <?php echo $lesson['Lesson']['main_content'] ?><br />
</div>
<div>
  <p> <?php
 echo $this->Html->link('Complete Lesson', array('controller' => 'lesson_statuses', 'action'=> 'add', $lesson['Lesson']['id'])); 
    ?></p>
</div>