<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
		<h3>Թեստի արդյունքը՝ <?=round($test_end_info['end_point'] / $test_end_info['max_point'] * 100)?>%  <?=$test_end_info['end_point']?> միավոր  <?=$test_end_info['max_point']?> հնարավորից, Տևողությունը՝ <?=$test_end_info['time']?></h3>
		</div>
	</div>
<?php if(false) foreach($test_end_info['questions'] as $question): 
	if($question['answer_mode']) {
		$type = 'checkbox';
	} else {
		$type = 'radio';
	}
?>  <br />
	<div class="row test_blok_inner">
		<h4 class="test_header <?php echo $question['is_right']? 'right_answer' : 'wrong_answer'?>"><?=$question['question']?></h4>
		<div class="row answers_bloks">
		<?php foreach($question['answers'] as $answer):?>
			<div class="col-sm-12">
                <label class="<?php echo $answer['is_right']? 'right_answer' : 'wrong_answer'?>">
					<input type="<?=$type?>" <?php if(isset($answer['checked'])) echo 'checked';?> disabled="true" class="passing_input"  value="<?=$answer['id']?>" /> 
					<?=$answer['answer']?>
                </label></div>
		<?php endforeach;?>
		</div>
	</div><br />
<?php endforeach;?>
</div>