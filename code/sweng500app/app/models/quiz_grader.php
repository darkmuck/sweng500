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
	function grade($quiz, $quizSubmissions) {
		$results = new Results();
		$results->totalPoints = $this->calculatePoints($quiz);
		
		foreach($quiz['Question'] as $question) {
			$correctAnswer = $this->getCorrectAnswerFromQuestion($question);
			$submittedAnswer = $this->getSubmittedAnswer($question['id'],
				$quizSubmissions);
			if(!is_null($submittedAnswer) && 
				$correctAnswer->isValueCorrect($submittedAnswer['answer'])) {
				$results->addCorrectAnswer($question['id'], $correctAnswer->points);
			} else {
				$results->addIncorrectAnswer($question['id']);
			}
		}
		
		return $results;
	}
	
	function getSubmittedAnswer($questionId, $answers) {
		foreach($answers as $answer) {
			if($answer['QuizSubmission']['question_id'] == $questionId) {
				return $answer['QuizSubmission'];
			}
		}
		return null;
	}
	
	function getCorrectAnswerFromQuestion($question) {
		$correctAnswer = new CurrentAnswer();
		$correctAnswer->questionType = $question['type'];
		$correctAnswer->questionId = $question['id'];
		$correctAnswer->points = $question['points'];
		
		foreach($question['Answer'] as $answer) {
			if($answer['correct']) {
				if($question['type'] == 0) {
					$correctAnswer->answer = $answer['value'];
				} else if($question['type'] == 1) {
					$correctAnswer->answer = $answer['id'];
				}
				
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
	var $questionType;
	var $answer;
	var $points;
	
	public function isValueCorrect($submittedAnswer) {
		$correct = false;
		switch($this->questionType) {
			case 0:
				$correct = (strtolower(trim($this->answer)) == strtolower(trim($submittedAnswer)));
				break;
			case 1:
				$correct = intval($submittedAnswer) == intval($this->answer);
				
		}

		return $correct;
	}
}

//This class is the result of the quiz. Has total points, (in)correct answers and points received
class Results {
	var $answerRubric = array();
	var $points = array();
	var $totalPoints;
	
	public function Results(){}
	
	
	public function addCorrectAnswer($questionId, $points) {
		$this->answerRubric[$questionId] = true;
		$this->points[$questionId] = $points;
	}
	
	public function addIncorrectAnswer($questionId) {
		$this->answerRubric[$questionId] = false;
		$this->points[$questionId] = 0;
	}
	
	public function isAnswerCorrect($questionId) {
		return $this->answerRubric[$questionId];
	}
	
	public function getCorrectPoints() {
		$p = 0;
		foreach($this->points as $correctPoints) {
			$p += $correctPoints;
		}
		return $p;
	}
	
	public function getPercentage() {
		return ($this->getCorrectPoints()/$this->totalPoints)*100;
	}
	
	public function getNumberCorrect() {
		$c = 0;
		foreach($this->answerRubric as $answer) {
			$c += $answer ? 1 : 0;
		}
		
		return $c;
	}
	
	public function getNumberOfQuestions() {
		return sizeof($this->answerRubric);
	}
	
	
}
?>
