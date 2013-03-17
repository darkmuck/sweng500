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

<div>
    <h2><?php echo $bookmark_lesson['Lesson']['name'];?> </h2>
    <hr />
    <b>Main Content:</b> <?php echo $bookmark_lesson['Lesson']['main_content'] ?><br />
</div>
<div>
  <p> <?php
 echo $this->Html->link('Complete Lesson', array('controller' => 'lesson_statuses', 'action'=> 'add', $bookmark_lesson['Lesson']['id'])); 
    ?></p>
</div>