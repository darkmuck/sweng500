<div class="users login">

    <h2>Welcome!</h2>

    <?php
    if ($this->Session->check('Auth.User') == 0) {
        echo 'It appears you are not logged in. Please '. $html->link('click here to login.', array('action'=>'login'));
    } else {
        echo 'You appear to be logged in. '. $html->link('Cick here to log out', array('action'=>'logout'));
    }
    ?>

</div>
