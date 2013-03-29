

<?php $this->Html->addCrumb('About');?>

<div class="users about", align="center">

	<style type="text/css">
		table {width: 800px;}
		td {text-align: center}
	</style>

    <?php echo '<h2>About the', $this->Html->image('logo3.png', array('alt' => 'Team 3 eLearning System', 'width' => '250')), '<h4>Version1.0 - Spring 2013'?>
	
	<hr width="800" />
	
	<h4>Developed by<br><br>
	Graduate Students of<br><br>
	The Pennsylvania State University<br><br></h4>
	
	<table>
		<tr>
			<td><?php echo $this->Html->image('Bill.jpg', array('alt' => 'Bill', 'width' => '200'))?></td>
			<td><?php echo $this->Html->image('Kevin.jpg', array('alt' => 'Kevin', 'width' => '200'))?></td>
			<td><?php echo $this->Html->image('Dave.jpg', array('alt' => 'Dave', 'width' => '200'))?></td>
			<td><?php echo $this->Html->image('Dawn.jpg', array('alt' => 'Dawn', 'width' => '200'))?></td>
		</tr>
		<tr>
			<td><h4>William DiStefano</td>
			<td><h4>Kevin Scheib</td>
			<td><h4>David Singer</td>
			<td><h4>Dawn Viscuso</h4></td>
		</tr>		
	</table>
	
	<hr width="800" />
	
	<h4>Under the Guidance of<br><br>
	Dr. Mohamad Kassab, Assistant Professor<br><br>
	SWENG 500: Advanced Software Engineering Studio</h4>

	
</div>
