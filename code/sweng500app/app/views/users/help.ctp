

<?php $this->Html->addCrumb('Help');?>

<div class="users help">

    <h2>Help</h2>

    <h4>Frequently Asked Questions</h4>

    <b>How do I change my password?</b>
    <br />
        &nbsp;&nbsp;&nbsp;
    <?php 
        if (in_array($Auth['User']['type_id'], array('2','3'))) { ?>
            Visit the Start page and click on the <?php echo $this->Html->link('Change Password', '/users/edit/'. $Auth['User']['id']); ?> link.
    <?php
        } else { ?>
        	Visit the Edit User page for your user account here:  <?php echo $this->Html->link('Edit User Account', '/users/edit/'. $Auth['User']['id']); ?>.
    <?php } //end if ?>
    <br /><br />

    <b>How does a new student register for an account?</b>
    <br />
        &nbsp;&nbsp;&nbsp;
        When not logged into the system, the student can click on the menu item 'Register' to create a new student account.
    <br /><br />

    <b>If my question is not answered here how do I get more help?</b>
    <br />
        &nbsp;&nbsp;&nbsp;
        Visit the <?php $this->Html->link('Contact Us', '/users/contactus'); ?> page for contact information.
    <br /><br />

</div>
