<?php
header('Content-type: ' . $lessonContent['LessonContent']['filetype']);
header('Content-length: ' . $lessonContent['LessonContent']['filesize']); 
header('Content-Disposition: attachment; filename="'.$lessonContent['LessonContent']['filename'].'"');

echo $content_for_layout;
die();
?>