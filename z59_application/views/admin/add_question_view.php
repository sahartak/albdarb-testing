<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row"><h1 class="page_title">Ավելացնել Հարց</h1><br /></div>
    <div class="row">
        <a href="<?=site_url('admin/import_tests/'.$test['id'])?>"><h3>Ներմուծել հարցերը այլ թեստերից</h3></a>
    </div>
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
				<textarea class="form-control" name="question" id="question" required="true"></textarea>
			</div>
		</div>
		<div class="row">
			
			<div class="col-sm-12"><label for="answer_mode">Ճիշտ պատասխաններ նշելու քանակը</label></div>
			<div class="col-sm-12">
				<select class="form-control" name="answer_mode" id="answer_mode">
					<option value="0">Մեկ ճիշտ պատասխան</option>
					<option value="1">Մեկից ավելի ճիշտ պատասխաններ</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12"><label for="category">Հարցը որ թեմային է վերաբերվում</label></div>
			<div class="col-sm-12">
				<select class="form-control" name="category" id="category">
					<option value="0">Առանց թեմայի</option>
				<?php if($categories) foreach($categories as $cat): ?>
					<option value="<?=$cat['id']?>"><?=$cat['name']?></option>
				<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12"><label for="difficulty">Բարդության աստիճան</label></div>
			<div class="col-sm-12">
				<select name="difficulty" id="difficulty" class="form-control">
				<?php foreach($difficulty as $dif):?>
					<option value="<?=$dif['id']?>"><?=$dif['difficulty_name']?></option>
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
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="col-sm-12" id="answers_block">
		
		</div>
	</div>
</div>
	<div class="row">
		<div class="col-sm-12 align_center">
			<input type="hidden" name="create_mode" id="create_mode" />
			<input type="submit" class="hidden" id="submit_form" />
			<a class="btn btn-success submit_button" data-mode="1">հաստատել և ավելացնել նոր հարց</a>&nbsp;
			<a class="btn btn-primary submit_button" data-mode="0" >հաստատել և դիտել թեստը</a>
		</div>
	</div>
    </form>
</div>

<div class="hidden" id="temp_answer"></div>

<div class="hidden" id="one_right_answer_template">
	<div class="row">
		<div class="col-xs-8">
			<textarea class="form-control" required="true"></textarea>
		</div>
		<div class="col-xs-1">
			<input type="radio" class="is_right" name="is_right" required="true" />
		</div>
		<div class="col-xs-3"><input type="number" class="form-control answer_point"  step="0.1" value="0" max="<?=$test['point']?>" /></div>
	</div>
</div>