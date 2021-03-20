<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin">Գլխավոր</a></li>
                    <li class="breadcrumb-item"><a href="<?=site_url('admin/view_test/' . $question['test_id'])?>">Թեստ <?=$question['test_id']?></a></li>
                    <li class="breadcrumb-item active"><a href="<?=site_url('admin/edit_question/' . $question['id'])?>">Հարց <?=$question['id']?></a></li>
                </ol>
            </nav>
        </div>
    </div>

	<div class="row"><h1 class="page_title">Խմբագրել Հարցը</h1><br /></div>
<?php
	echo validation_errors();
	echo form_open('',array('id' => 'question_form'));
?>
<div class="row">
	<div class="col-md-6 col-sm-12">
		<div class="row"><h2>Լրացրեք հարցի տվյալները</h2></div>
		<div class="row">
			<div class="col-sm-12"><label for="question">Մուտքագրեք հարցը</label></div>
			<div class="col-sm-12">
				<textarea class="form-control" name="question" id="question" required="true" rows="5"><?=set_value('question', $question['question'])?></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12"><label for="answer_mode">Ճիշտ պատասխաններ նշելու քանակը</label></div>
			<div class="col-sm-12">
				<select class="form-control" name="answer_mode" id="answer_mode">
					<option value="0">Մեկ ճիշտ պատասխան</option>
					<option value="1" <?php if($question['answer_mode']) echo 'selected';?>>Մեկից ավելի ճիշտ պատասխաններ</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12"><label for="category">Հարցը որ թեմային է վերաբերվում</label></div>
			<div class="col-sm-12">
				<select class="form-control" name="category" id="category">
				<?php if($categories) foreach($categories as $cat): ?>
					<option value="<?=$cat['id']?>" <?php if($question['category'] == $cat['id']) echo 'selected';?> ><?=$cat['name']?></option>
				<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12"><label for="difficulty">Բարդության աստիճան</label></div>
			<div class="col-sm-12">
				<select name="difficulty" id="difficulty" class="form-control">
				<?php foreach($difficulty as $dif):?>
					<option value="<?=$dif['id']?>" <?php if($question['difficulty'] == $dif['id']) echo 'selected';?> ><?=$dif['difficulty_name']?></option>
				<?php endforeach;?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12">
		<div class="row"><h2>Լրացրեք Պատասխանների տվյալները</h2></div>
		<div class="row">
			<div class="col-sm-12"><label for="qty">Նշեք պատասխանների քանակը</label></div>
			<div class="col-sm-12">
				<select id="qty" name="qty" class="form-control" required>
					<option value="">Նշված չի</option>
					<?php
						for($i=2;$i<11;$i++) {
							$selected = ($i == count($question['answers'])) ? 'selected' : '';
							echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="col-sm-12" id="answers_block">
    <?php
        if(!empty($question['answers'])):
            $answer_mode = $question['answer_mode'] ? 'checkbox' : 'radio';
            $answ_name = $question['answer_mode'] ? '[]' : '';
            $i=1;

    ?>
        <?php if($question['answer_mode']):?>
            <?php foreach($question['answers'] as $answer):?>
                <div class="row">
                    <div class="col-xs-8">
                        <textarea class="form-control" required="true" name="answer_<?=$i?>"><?=$answer['answer']?></textarea>
                    </div>
                    <div class="col-xs-1">
                        <input type="checkbox" class="is_right" name="is_right[]" value="<?=$i?>" required="true" <?php if($answer['is_right']) echo 'checked';?> />
                    </div>
                    <div class="col-xs-3 "><input type="number" name="point_<?=$i?>" class="form-control answer_point" step="0.1" value="<?=$answer['point']?>" /></div>
                </div>
            <?php $i++; endforeach;?>
        <?php else :?>

            <?php foreach($question['answers'] as $answer):?>
                <div class="row">
                    <div class="col-xs-8">
                        <textarea class="form-control" required="true" name="answer_<?=$i?>"><?=$answer['answer']?></textarea>
                    </div>
                    <div class="col-xs-1">
                        <input type="<?=$answer_mode?>" value="<?=$i?>" class="is_right" name="is_right<?=$answ_name?>" required="true" <?php if($answer['is_right']) echo 'checked';?> />
                    </div>
                    <div class="col-xs-3 "><input type="number" name="point_<?=$i?>" class="form-control answer_point" step="0.1" value="<?=$answer['point']?>" /></div>
                </div>
            <?php $i++; endforeach;?>
        <?php endif;?>

    <?php endif?>
		</div>
	</div>
</div> 
	<div class="row">
		<div class="col-sm-12 align_center">
			<input type="hidden" name="create_mode" id="create_mode" />
			<input type="submit" id="submit_form" class="btn btn-success" value="Հաստատել" />
		</div>
	</div>
</form>
</div>

<div class="hidden" id="temp_answer"></div>

<div class="hidden" id="one_right_answer_template">
    <div class="row">
        <div class="col-sm-11">
            <textarea class="form-control" required="true"></textarea>
        </div>
        <div class="col-sm-1">
            <input type="radio" class="is_right" name="is_right" required="true" />
        </div>
    </div>
</div>