<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo 'Team 3 eLearning System - '. $title_for_layout; ?></title>
    <?php echo $this->Html->meta('icon'); ?>
    <?php
        echo $this->Html->script(array('jquery-1.9.1.min.js','bootstrap.min.js', 'tiny_mce/jquery.tinymce.js'));
        echo $scripts_for_layout;
    ?>
    <link rel="stylesheet" type="text/css" href="/sweng500app/css/stylesheet-custom.css" id="stylesheet-custom" />
    <link rel="stylesheet" type="text/css" href="/sweng500app/css/bootstrap.css" id="stylesheet-bootstrap" />

</head>
<body>
  <a name="top"/>
  <div class="wrap">
    <div class="container">
        <div class="header">
            <?php echo $this->Html->image('logo2.png', array('alt' => 'Team 3 eLearning System'))?>
        </div>
        <div class="navbar">
        <div class="navbar-inner">
        <?php
        
            echo $this->Html->link('Home', array('controller'=>'Users','action'=>'start'),array('class'=>'brand'));
            echo '<ul class="nav">';
            echo '<li>'. $this->Html->link('Courses', array('controller'=>'Courses','action'=>'index')) .'</li>';
            if($this->Session->read('Auth.User.type_id') == 3) {
            	echo '<li>'. $this->Html->link('Roster', array('controller'=>'Rosters','action'=>'index')) .'</li>';
            }
            if($this->Session->read('Auth.User.type_id') == 1) {
            	echo '<li>'. $this->Html->link('Users', array('controller'=>'Users','action'=>'index')) .'</li>';
            }
            
		    echo '<li>'. $this->Html->link('About', array('controller'=>'Users','action'=>'about')) .'</li>';
		    echo '<li>'. $this->Html->link('Contact Us', array('controller'=>'Users','action'=>'contactus')) .'</li>';
		    echo '<li>'. $this->Html->link('Help', array('controller'=>'users','action'=>'help')) .'</li>';
		    
		    if ($this->Session->check('Auth.User') == 0) {
                echo '<li>'. $this->Html->link('Login', array('controller'=>'Users','action'=>'login')) .'</li>';
                echo '<li>'. $this->Html->link('Register', array('controller'=>'Users','action'=>'register')) .'</li>';
            } else {
                echo '<li>'. $this->Html->link('Logout', array('controller'=>'Users','action'=>'logout')) .'</li>';
            }
        ?>
        </div>
        <div class="breadcrumb">
            <?php echo $this->Html->getCrumbs(' > ', 'Start');?>
        </div>
              <?php 
	          echo $this->Html->link($this->Html->image('icon-printer.jpg', array('height'=>'25','width'=>'25','style'=>'float:right;')), 
		  '#top', array('escape'=>false,'onClick'=>
		  "document.getElementById('stylesheet-custom').href='/sweng500app/css/print.css';document.getElementById('stylesheet-bootstrap').href=''")
		  );
	      ?>
        </div>
        <div id="content">
            <?php echo $this->Session->flash(); ?>
            <?php echo $content_for_layout; ?>
        </div>
    </div>
    <div id="push"></div>
  </div>
    <div id="footer">
      <div class="container">
        <p class="muted credit">2013 - Team 3 eLearning System</p>
      </div>
    </div>
</body>
</html>
