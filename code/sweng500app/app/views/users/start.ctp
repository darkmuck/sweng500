

<?php $this->Html->addCrumb('Welcome!');?>

<div class="users start">

    <h2>Welcome to the Team 3 eLearning System!</h2>

    <?php
    if ($this->Session->check('Auth.User') == 0) {
        echo 'It appears you are not logged in. Please '. $html->link('click here to login.', array('action'=>'login')) .' or if you are a new student, '. $html->link('register', array('action'=>'register')) .' for an account.';
    } else {
        echo 'You appear to be logged in. '. $html->link('Cick here to log out', array('action'=>'logout'));
    }
    ?>

</div>
