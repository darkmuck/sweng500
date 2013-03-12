<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quiz_grader.test.php
 * Description: 
 * Created: Mar 11, 2013
 * Modified: Mar 11, 2013 7:57:12 PM
 * Modified By: Kevin Scheib
*/

App::import('Model','QuizGrader');


	
class QuizGraderTestCase extends CakeTestCase
{
	var $testQuiz = array(
		'Quiz' => array(
			'id' => 1,
			'lesson_id' => 1
		),
		'Question' => array(
			array(
				'id' => 1,
				'type' => 2,
				'points' => 10,
				'question' => 'Please type in \'Two\' to answer the question.',
				'Answer' => 
					array(
						array(
							'id' => 1,
							'question_id' => 1,
							'value' => 'Two',
							'correct' => true
						)
					)
			),
			array(
				'id' => 2,
				'type' => 1,
				'points' => 15,
				'question' => 'Is this a multiple choice question?',
				'Answer' =>
					array(
						array(
							'id' => 2,
							'question_id' => 2,
							'value' => 'Yes',
							'correct' => true
						),
						array(
							'id' => 3,
							'question_id' => 2,
							'value' => 'No',
							'correct' => false
						)
					)
			)
		)
	);
	var $testQuizSubmission = array(
		'QuizSubmission' => array(
			'id' => 1,
			'quiz_id' => 1,
			'user_id' => 1
		),
		'SubmittedAnswer' => array(
			array(
				'id' => 1,
				'quiz_submission_id' => 1,
				'question_id' => 1,
				'answer' => 'ttwo'
			),
			array(
				'id' => 2,
				'quiz_submission_id' => 1,
				'question_id' => 2,
				'answer' => 'Yes'
			)
		)
	);
	
	
	
	function testGrade() {
		$this->result = new Results();
		$this->result->totalPoints = 25;
		$this->result->addPoints(15);
		$this->result->addIncorrectAnswer(1);
		$this->result->addCorrectAnswer(2);
		
		
		$this->QuizGrader =& ClassRegistry::init('QuizGrader');

		$result = $this->QuizGrader->grade($this->testQuiz, $this->testQuizSubmission);
		
		$this->assertEqual($this->result, $result);
	}
}
?>
