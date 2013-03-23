

<?php $this->Html->addCrumb('Login/Logout', '/users/login');?>

<div>

    <?php
        echo $this->Form->create('User', array('action'=>'login', 'class'=>'form-signin'));
        echo '<h2 class="form-signin-heading">Login</h2>';
        echo $this->Form->input('username', array('class'=>'input-block-level'));
        echo $this->Form->input('password', array('class'=>'input-block-level'));
        echo $this->Form->button('Login', array('type'=>'submit','class'=>'btn btn-large btn-primary'));
        echo $this->Form->end();
    ?>

</div>