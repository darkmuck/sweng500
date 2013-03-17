<?php
/* SWENG500 - Team 3
 * William DiStefano, Dawn Viscuso, Kevin Scheib, David Singer
 *
 * File: add.ctp
 * Description: 
 * Created: Mar 12, 2013
 * Modified: Mar 12, 2013 9:05:10 PM
 * Modified By: Kevin Scheib
*/
?>
<?php
	$questionCount = 0;
	if(!empty($this->data['Question'])) {
		$questionCount = sizeof($this->data['Question']);	
	}
	 
?>
<style type="text/css">
	label { display: inline;}
</style>
<script type="text/javascript">
	var questionTypes = ['Fill in the blank', 'Mulitple choice'];
	var questionCount = <?php echo $questionCount;?> ;
	function addQuestion() {
		buildQuestionForm(questionCount);
		
		questionCount++;
		return false;
	}
	
	function buildQuestionForm(questionCount) {
		var baseName = 'data[Question][' + questionCount + ']';

		var container = $('#QuestionTemplate').clone().attr({id: 'Question' + questionCount}).css('display', 'block');
		container.find('#removeButtonTemplate').attr({
			id: ''
		}).on('click', function() {removeQuestion(questionCount)});
		container.find('#pointsTemplate').attr({
			id: '',
			name: baseName + '[points]'
		});
		container.find('#questionTemplate').attr({
			id: '',
			name: baseName + '[question]'
		});
		
		container.find('#QuestionAnswers').attr({
			id: 'Question'+questionCount+'Answers'
		});
		
		container.find('#typeTemplate').attr({
			id: '',
			name: baseName + '[type]'
		}).change(function(e){
			var v = e.currentTarget.value;
			buildAnswerOptions(v, '#Question' + questionCount + 'Answers', baseName);
		});
		
		$('#questions').append(container);
	}
	
	function buildOptions(sel, count) {
		var divId = '#Question'+count+'Answers';
		var base = 'data[Question]['+count+']'
		buildAnswerOptions(sel.options[sel.selectedIndex].value, divId, base );
	}
	
	function buildAnswerOptions(type, divId, baseName) {
		var answerName = baseName + '[Answer]';
		$(divId).html('');
		
		var currentAnswerId = $(divId).children('input[type=text]').length;
		
		if(type == "0") { //fill in the blank
			var currentAnswer = answerName + '['+currentAnswerId+']';
			var label = $('<label>').attr({for: 'Answer'}).html('Answer:');
			var input = $('<input>').attr({
				name: currentAnswer + '[value]',
				type: 'text'
			});
			var correct = $('<input>').attr({
				name: currentAnswer + '[correct]',
				value: '1',
				type: 'hidden'
			});
			$(divId).append(correct);
			$(divId).append(label);
			$(divId).append(input);
		} else if (type == "1") { // multiple choice
			var btn = $('<input>').attr({
				type: 'button',
				value: 'Add Choice'
			}).on('click', function(e) {
				addChoice(divId, answerName);
			});
			$(divId).append(btn);
		}
	}
	
	function addChoice(id, answerName) {
		var elem = $(id);
		var currentAnswerId = elem.find('input[type="text"]').length;
		var currentAnswerName = answerName + '['+currentAnswerId+']';
		var choiceTable = $(id + 'Choices');
		if(choiceTable.size() == 0) {
			var tableId = id.slice(1);
			choiceTable = $('<table>').attr({
				id: tableId + 'Choices'
			}).append($('<thead>').append($('<tr>').append(
				$('<th>').text('Choice')
			).append(
				$('<th>').text('Correct?').attr({
					align: 'center'
				})
			).append($('<th>'))));
			elem.append(choiceTable);
		}
		
		choiceTable.append(
			$("<tr>").append(
				$('<td>').append(
					$('<input>').attr({
						name: currentAnswerName + '[value]',
						type: 'text'
					})
				)
			).append(
				$('<td>').attr({align: 'center'}).append(
					$('<input>').attr({
						name: currentAnswerName + '[correct]',
						value: '1',
						type: 'radio'
					}).attr({
						align: 'center'
					}).on('click', function(e) {
						uncheckCorrect(currentAnswerName, answerName);
					})
				)
			).append(
				$('<td>').append(
					$('<input>').attr({
						type: 'button',
						value: 'Remove Choice'
					}).on('click', function(e) {
						$(this).parent().parent().remove();
					})
				)
			)
		)
	}
	
	function uncheckCorrect(currentAnswerName, answerName) {
		$('input[name^="'+answerName+'"][name$="[correct]"]').each(function(i, e){
			var current = currentAnswerName + '[correct]';
			if($(e).attr('name') != current) {
				$(e).prop('checked', false);
			}
		})
	}
	
	function removeRowByIdx(tableId, rowindex) {
		$('#'+tableId+' tbody tr:eq('+rowindex+')').remove();
	}
	
	function removeQuestion(index) {
		$('#Question' + index).remove();
	}

</script>

<div id="QuestionTemplate" style="display:none">
	
	<table>
		<tr>
			<td>
				<label for="Type">Question Type:
					<select id="typeTemplate" name="">
						<option value=""></option>
						<option value="0">Fill in the blank</option>
						<option value="1">Mulitple choice</option>
					</select>
				</label>
			</td>
			<td>
				<label for="Points">Points:
					<input type="text" id="pointsTemplate" name="" />
				</label>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<label for="Question">Question:</label>
				<input type="text" id="questionTemplate" name="" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div id="QuestionAnswers">
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" value="Remove Question" id="removeButtonTemplate"/>
			</td>
		</tr>
	</table>
	<hr>
	
</div>

<div>
	<?php echo $this->Form->create('Quiz', array('url'=>'/quizzes/edit')); ?>
    <h2>Quiz for <?php echo $this->data['Lesson']['name'] ?></h2>
    
    <?php
    	  echo $this->Form->hidden('Lesson.name', array('value' => $this->data['Quiz']['lesson_id']));
    	  echo $this->Form->hidden('Quiz.id', array('type' => 'hidden', 'value' => $this->data['Quiz']['id']));
     	  echo $this->Form->hidden('Quiz.lesson_id', array('value' => $this->data['Quiz']['lesson_id'])); 
     	  echo $this->Form->hidden('Quiz.course_id', array('value' => $this->data['Quiz']['course_id'])); 
     	  echo $this->Form->input('Quiz.name', array('label' => 'Quiz Name:', 'maxlength' => 50, 'size' => 10)); ?>
 	<br/>
 	<b>Questions</b>
 	<?php echo $this->Form->button('Add Question', array('type' => 'button', 'onClick' => 'javascript:addQuestion()')); ?>
 	<br />
 	<hr />
 	<div id="questions">
 	<?php
 	if(!empty($this->data['Question'])) {
	 	$i = 0;
	 	foreach($this->data['Question'] as $question) {
 	?>
	 	<div id="Question<?php echo $i ?>">
	 	
	 	<div id="Question<?php echo $i ?>">
	 	<table>
		<tr>
			<td>
	<?php
			echo $this->Form->input('Question.'.$i.'.id', array('type' => 'hidden'));
			echo $this->Form->input('Question.'.$i.'.type', array('label'=> 'Question Type', 
				'onchange' => 'buildOptions(this, '.$i.')'));
	?>
			</td>
			<td>
	<?php
			echo $this->Form->input('Question.'.$i.'.points', array('type' => 'text', 'label' => 'Points:'));
	?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
	<?php
			echo $this->Form->input('Question.'.$i.'.question', array('type' => 'text', 'label' => 'Question:'));
	?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
		
		<div id="Question<?php echo $i; ?>Answers">
		<!-- 0 = fill in the blank, 1 = multiple choice-->
		<?php
			if($this->data['Question'][$i]['type'] == 0) {
				echo $this->Form->input('Question.'.$i.'.Answer.0.id', array('type'=> 'hidden'));
				echo $this->Form->input('Question.'.$i.'.Answer.0.quiz_id', array('type'=> 'hidden'));
				echo $this->Form->input('Question.'.$i.'.Answer.0.correct', array('type' => 'hidden'));
				echo $this->Form->input('Question.'.$i.'.Answer.0.value', array('type' => 'text', 'label' => 'Answer:'));
				
			} else if($this->data['Question'][$i]['type'] == 1) {
				echo $this->Form->button('Add Choice', array('type' => 'button', 
					'onclick' => 'javascript:addChoice(\'#Question'.$i.'Answers\', \'data[Question]['.$i.'][Answer]\')'));
				if(!empty($this->data['Question'][$i]['Answer'])) {
		?>
			<table id="Question<?php echo $i; ?>AnswersChoices">
				<thead>
					<tr>
						<th>Answer</th><th align="center">Correct?</th><th></th>
					</tr>
				</thead>
				<tbody>
				<?php
					$k = 0;
					foreach ($this->data['Question'][$i]['Answer'] as $answer) {
						echo '<tr><td>';
						echo $this->Form->input('Question.'.$i.'.Answer.'.$k.'.id', array('type'=> 'hidden'));
						echo $this->Form->input('Question.'.$i.'.Answer.'.$k.'.question_id', array('type'=> 'hidden'));
						echo $this->Form->input('Question.'.$i.'.Answer.'.$k.'.value', array('label' => false));
						echo '</td><td align="center">';
						echo $this->Form->input('Question.'.$i.'.Answer.'.$k.'.correct', 
							array('type' => 'radio', 'label' => false, 'options' => array(1=>''), 'div' => false,
							'onclick' => 'javascript:uncheckCorrect(\'data[Question]['.$i.'][Answer]['.$k.']\',\'data[Question]['.$i.'][Answer]\')'));
						echo '</td><td>';
						echo $this->Form->button('Remove Choice', array('type' => 'button', 
							'onclick' => 'removeRowByIdx(\'Question'.$i.'AnswersChoices\', '.$k.')'));
						echo '</td></tr>';
						$k++;
					}
				?>
				</tbody>
				</table>
		<?php
				}
			}
		?>
		</div>
		</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->Form->button('Remove Question', array('onclick' => 'removeQuestion('.$i.')')); ?>
			</td>
		</tr>
		</table>
		<hr>
		</div>
 	<?php
	 		$i++;
	 	}
 	}
 	?>
 	
 	</div>
 	
 	<?php echo $this->Form->button('Submit', array('type'=>'Add','class'=>'btn btn-success'));?>
    <?php echo $this->Form->end(); ?>
</div>
 	
    