<?php defined('BASEPATH') OR exit('No direct script access allowed');
$is_admin = $this->router->fetch_class() == 'admin';

$display_mode = intval($test_end_info['display_mode']);

if($is_admin) {
    //$display_mode = 3;
}
?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
		<h3>Թեստի արդյունքը՝ <?=round($test_end_info['end_point'] / $test_end_info['max_point'] * 100)?>%,   Միավոր` <?=$test_end_info['end_point']?> / <?=$test_end_info['max_point']?>, Տևողությունը՝ <?=$test_end_info['time']?></h3>
		</div>
	</div>
<?php $i=0; if($display_mode > 0) foreach($test_end_info['questions'] as $question):
    $i++;
	if($question['answer_mode']) {
		$type = 'checkbox';
	} else {
		$type = 'radio';
	}
	if($question['is_right'] && $display_mode < 3) {
        continue;
    }
?>  <br />
	<div class="row test_blok_inner">
		<h4 class="test_header <?php echo $question['is_right']? 'right_answer' : 'wrong_answer'?>">
            <?=$i,'. ';?>
			<?=$is_admin ? "(ID {$question['question_id']})" : ''?>
			<?=$question['question']?>
		</h4>
		<div class="row answers_bloks">
		<?php
		    foreach($question['answers'] as $answer):

                ?>
			<div class="col-sm-12">
                <label class="<?php if($display_mode > 1) echo $answer['is_right']? 'right_answer' : 'wrong_answer'?>">
					<input type="<?=$type?>" <?php if(isset($answer['checked'])) echo 'checked';?> disabled="true" class="passing_input"  value="<?=$answer['id']?>" />
					<?=$answer['answer']?>
				</label></div>
		    <?php endforeach;?>
		</div>
	</div><br />
<?php endforeach;?>
</div>