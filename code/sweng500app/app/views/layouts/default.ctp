<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title_for_layout; ?></title>
    <?php echo $this->Html->meta('icon'); ?>
    <?php
        //echo $this->Html->script(array('jquery-1.9.1.min.js',));
        //echo $this->Html->css(array('stylesheet'));
        echo $scripts_for_layout;
    ?>
</head>
<body>
    <div id="container">
        <div id="header"></div>
            <div id="name"><h2>SWENG500 - Team 3</h2></div>
            <div id="content">
                <?php echo $this->Session->flash(); ?>
                <?php echo $content_for_layout; ?>
            </div>
        </div>
        <div id="footer"></div>
    </div>
<?php echo $this->element('sql_dump');?>
</body>
</html>
