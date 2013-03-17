<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: UsersController.php
 * Description: This controller provides request handling for users data
 * Created: 2013-02-16
 * Modified: 2013-02-16 19:38
 * Modified By: William DiStefano
*/
?>
<script type="text/javascript">
        $(function() {
                $('textarea.tinymce').tinymce({
                        // Location of TinyMCE script
                        script_url : '<?php echo $this->Html->url('/js/tiny_mce/tiny_mce.js') ?>',

                        // General options
                        theme : "advanced",
                        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

                        // Theme options
                        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : true,

                        // Drop lists for link/image/media/template dialogs
                        template_external_list_url : "lists/template_list.js",
                        external_link_list_url : "lists/link_list.js",
                        external_image_list_url : "lists/image_list.js",
                        media_external_list_url : "lists/media_list.js",
                });
        });
</script>
<div>
    <h2>Edit Lesson for <?php echo $course['Course']['course_name'] ?></h2>
    
    <?php echo $this->Form->create('Lesson', array('action'=>'edit')); ?>
    <?php echo $this->Form->hidden('course_id', array('value'=>$lesson['Lesson']['course_id'])); ?>
    <?php echo $this->Form->hidden('id', array('value'=>$lesson['Lesson']['id'])); ?>
    <table class="table">
        <tr>
            <td><?php echo $this->Form->input('name', array('maxlength'=>'50','label'=>'Lesson Name', 'value'=>$lesson['Lesson']['name']));?></td>
        </tr>
        <tr>
        	<td><?php echo $this->Form->textarea('main_content', array('label' => 'Lesson Text', 'class' => 'tinymce', 'value'=>$lesson['Lesson']['main_content'])); ?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-success'));?></td>
        </tr>
    </table>
    
    <h3>Supporting Content for Lesson</h3>
    <?php
        echo '<p>'. $this->Form->button('Add Content', array('type'=>'button','onClick'=>"location.href='".$this->Html->url('/lesson_contents/upload/'.$lesson['Lesson']['id'])."'", 'class'=>'btn btn-primary')) .'</p>';
    ?>
    <table class="table">
    	<tr>
    		<th>Filename</th>
    		<th>Type</th>
    		<th>URL</th>
    		<th>Actions</th>
    	</tr>
        <?php foreach($lesson['LessonContent'] as $lessonContent) : ?>
        <tr>
        	<td><?php echo $lessonContent['filename']; ?></td>
        	<td><?php echo $lessonContent['filetype']; ?></td>
        	<td><?php echo $this->Html->url('/lesson_contents/download/'. $lessonContent['id']) ?></td>
        	<td>
        		<?php echo $this->Form->button('Download', array('type'=>'button', 'class'=>'btn btn-warning', 'onClick'=>"location.href='".$this->Html->url('/lesson_contents/download/'.$lessonContent['id'])."'")) ?>
        		<?php echo $this->Form->button('Delete', array('type'=>'button', 'class'=>'btn btn-danger', 'onClick'=>"location.href='".$this->Html->url('/lesson_contents/delete/'.$lessonContent['id'])."'")) ?>
        	</td>
       	</tr>
        <?php endforeach; ?>
    </table>
    
    <h3>Quizzes for Lesson</h3>
    <?php
    	echo '<p>'.$this->Html->link('Add Quiz', array('controller' => 'quizzes', 'action' => 'add', $lesson['Lesson']['id'], $lesson['Lesson']['course_id']), array('class' => 'btn btn-primary')) . '</p>';
    ?>
    <table class="table">
    	<tr>
    		<th>Quiz Name</th>
    		<th></th>
		</tr>
	<?php
		foreach($lesson['Quiz'] as $quiz) {
	?>
		<tr>
			<td><?php echo $quiz['name']; ?></td>
			<td>
				<?php 
					echo $this->Html->link('Edit Quiz', array('controller' => 'quizzes', 'action' => 'edit', $quiz['id']), array('class' => 'btn btn-warning'));
					echo $this->Html->link('Delete Quiz', array('controller' => 'quizzes', 'action' => 'delete', $quiz['id'], $lesson['Lesson']['id']), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this quiz?');
				?>
			</td>
		</tr>
	<?php
		}
	?>
	</table>
    
    <?php echo $this->Form->end();?>
</div>
