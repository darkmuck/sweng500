<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo 'Team 3 eLearning System - '. $title_for_layout; ?></title>
    <?php echo $this->Html->meta('icon'); ?>
    <?php
        echo $this->Html->script(array(/*'jquery-1.9.1.min.js',*/'bootstrap.min.js'));
        echo $this->Html->css(array('bootstrap','stylesheet-custom'));
        echo $scripts_for_layout;
    ?>

</head>
<body>
  <div class="wrap">
    <div class="container">
        <div class="header">
            <h1>Team 3 eLearning System</h1>
        </div>
        <div class="navbar">
        <div class="navbar-inner">
        <?php
            echo $this->Html->link('Home', array('controller'=>'Users','action'=>'start'),array('class'=>'brand'));
            echo '<ul class="nav">';
            echo '<li>'. $this->Html->link('Courses', array('controller'=>'Courses','action'=>'index')) .'</li>';
            echo '<li>'. $this->Html->link('Lessons', array('controller'=>'Lessons','action'=>'index')) .'</li>';
            echo '<li>'. $this->Html->link('Grades', array('controller'=>'Grades','action'=>'index')) .'</li>';
            echo '<li>'. $this->Html->link('Users', array('controller'=>'Users','action'=>'index')) .'</li>';
            echo '</li>';


        ?>
        </div>
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
