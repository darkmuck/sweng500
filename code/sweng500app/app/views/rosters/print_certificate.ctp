<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: view.ctp
 * Description: Print completion certficate for selected course
 * Created: 2013-02-21
 * Modified: 2013-02-21 14:44
 * Modified By: David Singer
*/
?>
<p><a href="javascript:window.print()" >Print Certificate</a> </p> 
<body class="border2 border1">
<h1>CERTIFICATE OF COMPLETION</h1>
<img class="displayed" src="/sweng500app/img/mini_logo.gif" alt="Team 3 E-Learning">
<h2 class="nobox">AWARDED TO</h2>
<h3 class="name"><?php echo $name; ?></h3>
<h2 class="box"><?php echo $course['Course']['course_name']; ?><br />
<br /><?php echo date("m/d/Y h:i:s a"); ?>
</h2>
</body>
<p><?php echo $this->Html->link('Return To Course Home', array('controller'=>'courses','action'=>'launch',$course['Course']['id'])); ?></p>

