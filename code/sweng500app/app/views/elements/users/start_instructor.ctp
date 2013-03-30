<h4>Shortcuts:</h4>
<ul>
	<li><?php echo $this->Html->link('Courses', '/courses/index'); ?> - Manage courses, lessons, lesson contents, and quizzes.</li>
    <li><?php echo $this->Html->link('Grades', '/grades/index'); ?> - Manage student grades.</li>
    <li><?php echo $this->Html->link('Change Password', '/users/edit/'. $Auth['User']['id']); ?> - Change your password.</li>
    <li><?php echo $this->Html->link('About', '/users/about'); ?> - Information about the eLearning System.</li>
    <li><?php echo $this->Html->link('Help', '/users/help'); ?> - FAQs and Help for the eLearning System.</li>
    <li><?php echo $this->Html->link('Contact Us', '/users/contactus'); ?> - Contact information of the eLearning System development team.</li>
</ul>