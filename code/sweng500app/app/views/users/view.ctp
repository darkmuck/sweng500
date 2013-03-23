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

<?php $this->Html->addCrumb('Users', '/users/');?>
<?php $this->Html->addCrumb('View User ('. $user['User']['name'] .')', '/users/view/'. $user['User']['id']);?>

<div>
    <h2><?php echo $user['User']['name'];?> </h2>
    
    <b>Name:</b> <?php echo $user['User']['name'] ?><br />
    <b>Username:</b> <?php echo $user['User']['username']; ?><br />
    <b>Enabled:</b> <?php if ($user['User']['enabled'] == '1') { echo 'Yes'; } else { echo 'No'; }; ?><br />
    <b>Created:</b> <?php echo substr($user['User']['created'],0,10); ?><br />
    <b>Modified:</b> <?php echo substr($user['User']['modified'],0,10); ?><br />
    <b>Type:</b>
        <?php
            switch ($user['User']['type_id']) {
                case '1':
                	echo 'Administrator';
                	break;
                case '2':
                	echo 'Instructor';
                	break;
                case '3':
                	echo 'Student';
                	break;
                default:
                	break;
            }
        ?>
