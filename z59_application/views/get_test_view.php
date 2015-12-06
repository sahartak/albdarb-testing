<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container noselect">
<?php 
	echo form_open();
?>
		<div class="row">
			<h1><?=$test_info['name']?></h1>
		</div>
	<?php $i=1; $count = count($test_passing); foreach($test_passing as $question): 
		if($question['answer_mode']) {
			$type = 'checkbox';
			$name = 'answer_'.$i.'[]';
		} else {
			$type = 'radio';
			$name = 'answer_'.$i;
		}
    ?>
		<div class="row test_blok_inner test_passing_question" id="quesrion_blok_<?=$i?>">
			<h4 class="test_header"><?=$question['question']?></h4>
            <div class="col-sm-12"><h3>Հարց: <?=$i,'/',$count?></h3></div>
			<div class="row answers_bloks">
			<?php foreach($question['answers'] as $answer):?>
				<div class="col-sm-12"><label><input type="<?=$type?>" class="passing_input question_<?=$answer['question_id']?>" name="<?=$name?>" value="<?=$answer['id']?>" data-question="<?=$answer['question_id']?>" /> <?=$answer['answer']?></label></div>
			<?php endforeach;?>
			</div>
			<p class="align_center">
			<?php if($i == $count):?>
				<button class="btn btn-primary open_question_btn" data-open="<?=$i-1?>">Նախորդ հարցը</button> &nbsp; <a class="btn btn-danger" href="<?=site_url('end_test')?>" id="end_test">Ավարտել թեստը</a>
			<?php elseif($i == 1):?>
				<button class="btn btn-success open_question_btn" data-open="<?=$i+1?>">Հաջորդ հարցը</button>
			<?php else:?>
				<button class="btn btn-primary open_question_btn" data-open="<?=$i-1?>">Նախորդ հարցը</button> &nbsp; <button class="btn btn-success open_question_btn" data-open="<?=$i+1?>">Հաջորդ հարցը</button>
			<?php endif;?>
				
			</p>
		</div>
	<?php $i++; endforeach;?>
	</form>
	<div class="row align_center col-md-6 col-md-offset-3">
		<div class="clock "></div>
	</div>

	<input type="hidden" id="test_time" value="<?=$test_info['time']?>" />    
</div>