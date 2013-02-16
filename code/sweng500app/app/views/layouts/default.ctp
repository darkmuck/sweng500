<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title_for_layout; ?></title>
    <?php echo $this->Html->meta('icon'); ?>
    <?php
        //echo $this->Html->script(array('jquery-1.9.1.min.js',));
        echo $this->Html->css(array('stylesheet'));
        echo $scripts_for_layout;
    ?>
</head>
<body>
    <div id="container">
        <div id="header">
            <h1>SWENG500 - Team 3</h1>
        </div>
        <div id="mainMenu">
        <?php
            echo '<strong>Menu: </strong>';
            echo $this->Html->link('Start', array('controller'=>'Users','action'=>'start'));
            echo '  |  ';
            echo 'Courses';
            echo '  |  ';
            echo 'Lessons';
            echo '  |  ';
            echo 'Grades';
            echo '  |  ';
            echo $this->Html->link('Users', array('controller'=>'Users','action'=>'index'));

            echo '<span style="float: right; margin: 0em 0.50em 0 0;">';
            if ($this->Session->check('Auth.User') == 1) {
                echo $this->Html->link('Logout', array('controller'=>'Users','action'=>'logout'));
            } else {
                echo$this->Html->link('Login', array('controller'=>'Users','action'=>'login'));
            }
            echo '</span>';
        ?>
        </div>
        <div id="content">
            <?php echo $this->Session->flash(); ?>
            <?php echo $content_for_layout; ?>
        </div>
        <div id="footer">
            SWENG500 - Team 3 - 2013
        </div>
    </div>
</body>
<?php echo $this->element('sql_dump');?>
</html>
