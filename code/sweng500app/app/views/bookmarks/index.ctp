<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: index.ctp
 * Description: This view provides a listing of current student created bookmarks
 * Created: 2013-02-21
 * Modified: 2013-02-21 
 * Modified By: Dawn Viscuso
*/
?>

<div>
    <h2>Bookmarks</h2>
    

<table class="table">
    
    <tr>
         <th><?php echo $this->Paginator->sort('id'); ?></th>
         <th><?php echo $this->Paginator->sort('name'); ?></th>
         <th><?php echo $this->Paginator->sort('created'); ?></th>
         <th>Actions</th>
     </tr> 

 <?php  foreach ($bookmark as $bookmark) : ?>

    <tr>
        <td><?php echo $bookmark['Bookmark']['id']; ?></td>
        <td><?php echo $bookmark['Lesson']['name']; ?></td>
        <td><?php echo $bookmark['Bookmark']['created']; ?></td>
        <td>
            <?php 
            echo $this->Form->button('View', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'view',$bookmark['Lesson']['id']))."'", 'class'=>'btn btn-info'));
            echo $this->Form->button('Delete', array('onClick'=>"location.href='".$this->Html->url(array('action'=>'delete',$bookmark['Bookmark']['id']))."'", 'class'=>'btn btn-danger'));
            ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

    <div align="center" width="100%">
        <?php echo $this->Paginator->prev('<--  Previous Page');?>
        <?php echo $this->Paginator->numbers();?> | 
        <?php echo $this->Paginator->next('Next Page -->'); ?>
    </div>
</div>