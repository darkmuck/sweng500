<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: quizgrader.php
 * Description: 
 * Created: Mar 3, 2013
 * Modified: Mar 3, 2013 1:29:42 PM
 * Modified By: Kevin Scheib
*/

class QuizGrader extends AppModel{
	var $useTable = false;
	function grade($quiz, $quizSubmission) {
		$results = new Results();
		$results->totalPoints = $this->calculatePoints($quiz);
		
		foreach($quiz['Question'] as $question) {
			$correctAnswer = $this->getCorrectAnswerFromQuestion($question);
			$submittedAnswer = $this->getSubmittedAnswer($question['id'],
				$quizSubmission['SubmittedAnswer']);
			
			if(!is_null($submittedAnswer) && 
				$correctAnswer->isValueCorrect($submittedAnswer['answer'])) {
				$results->addPoints($correctAnswer->points);
				$results->addCorrectAnswer($question['id']);
			} else {
				$results->addIncorrectAnswer($question['id']);
			}
		}
		
		return $results;
	}
	
	function getSubmittedAnswer($questionId, $answers) {
		foreach($answers as $answer) {
			if($answer['question_id'] == $questionId) {
				return $answer;
			}
		}
		return null;
	}
	
	function getCorrectAnswerFromQuestion($question) {
		$correctAnswer = new CurrentAnswer();
		$correctAnswer->questionId = $question['id'];
		$correctAnswer->points = $question['points'];
		
		foreach($question['Answer'] as $answer) {
			if($answer['correct']) {
				$correctAnswer->answer = $answer['value'];
			}
		}
		
		return $correctAnswer;
	}
	
	function calculatePoints($quiz) {
		$points = 0;
		foreach($quiz['Question'] as $question) {
			$points += $question['points'];
		}
		
		return $points;
	}
}

//classes used by the algorithm to put merge info from both the question and answer "objects"
class CurrentAnswer {
	var $questionId;
	var $answer;
	var $points;
	
	public function isValueCorrect($submittedAnswer) {
		return (strtolower(trim($this->answer)) == strtolower(trim($submittedAnswer)));
	}
}

//This class is the result of the quiz. Has total points, (in)correct answers and points received
class Results {
	var $answerRubric = array();
	var $points;
	var $totalPoints;
	
	public function addPoints($points) {
		$this->points += $points;
	}
	
	public function addCorrectAnswer($questionId) {
		$this->answerRubric[$questionId] = true;
	}
	
	public function addIncorrectAnswer($questionId) {
		$this->answerRubric[$questionId] = false;
	}
	
	public function isAnswerCorrect($questionId) {
		return $this->answerRubric[$questionId];
	}
	
	
}
?>
