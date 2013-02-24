<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: lessoncontents_controller.php
 * Description: 
 * Created: Feb 23, 2013
 * Modified: Feb 23, 2013 12:36:44 PM
 * Modified By: Kevin Scheib
*/

class LessonContentsController  extends AppController {
	var $name = 'LessonContents';
	
	function upload($lessonId = null) {
		if(!empty($this->data))
		{
			$tmpFile = $this->data['LessonContent']['uploadfile'];
			$uploadfile = addslashes(fread(fopen($tmpFile['tmp_name'], "r"), 
				filesize($tmpFile['tmp_name'])));
			$this->data['LessonContent']['filename'] = $tmpFile['name'];
			$this->data['LessonContent']['filesize'] = filesize($tmpFile['tmp_name']);
			$this->data['LessonContent']['filetype'] = $tmpFile['type'];
			$this->data['LessonContent']['content'] = $uploadfile;
			$this->LessonContent->save($this->data);
		
			$this->redirect(array('controller' => 'Lessons', 'action' => 'edit', 
				$this->data['LessonContent']['lesson_id']));
		} else if(!empty($lessonId)) {
			$this->loadModel('Lesson');
			$this->Lesson->id = $lessonId;
			$lesson = $this->Lesson->read();
			$this->set('lesson', $lesson);
		}
	}
	
	function download($lessonContentId = null) {
		Configure::write('debug', 0);
	    $file = $this->LessonContent->findById($lessonContentId);

	    $this->set('lessonContent', $file);
	    $this->render(null, 'download');
	}
	
	function delete($lessonContentId = null) {
		if(!empty($lessonContentId)) {
			$this->LessonContent->id = $lessonContentId;
			$lessonContent = $this->LessonContent->read();
			$this->LessonContent->delete($lessonContentId);
			$this->redirect(array('controller' => 'Lessons', 'action' => 'edit', 
				$lessonContent['LessonContent']['lesson_id']));
		}
	}
}
?>
