<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<?php echo form_open();?>
			<div class="row">
				<?=validation_errors();?>
			</div>
			<div class="row">
				<label for="first_name">Անուն</label>
				<input type="text" class="form-control" name="first_name" id="first_name" value="<?=set_value('first_name')?>" required="true" maxlength="50"/>
			</div>
			<div class="row">
				<label for="last_name">Ազգանուն</label>
				<input type="text" class="form-control" name="last_name" id="last_name" value="<?=set_value('last_name')?>" required="true" maxlength="50"/>
			</div>
			<div class="row">
				<label for="father_name">Հայրանուն</label>
				<input type="text" class="form-control" name="father_name" id="father_name" value="<?=set_value('father_name')?>" required="true" maxlength="50"/>
			</div>
		<?php if(!$is_public):?>
			<div class="row">
				<label for="test_password">Թեստի գաղտնաբառը</label>
				<input type="hidden" name="test_id" value="<?=$test_id?>" />
				<input type="password" class="form-control" id="test_password" name="test_password" required="true"/>
			<?php if($invalid_pass) echo '<p>Գաղտնաբառը սխալ է</p>'?>
			</div>
		<?php endif;?>
			<div class="row">
				<label for="course">Խումբը</label>
				<select name="course" id="course" class="form-control" required="required">
					<option value="" selected>Նշեք Խումբը</option>
					<option value="0">Այլ</option>
				<?php foreach($courses as $course):?>
					<option value="<?=$course['id']?>"><?=$course['name']?></option>
				<?php endforeach;?>
				</select>
			</div>
			<div class="row hidden" id="course_name_block">
				<label for="course_name">Ներմուծեք խմբի անվանումը</label>
				<input type="text" class="form-control" name="course_name" id="course_name" value="<?=set_value('course_name')?>" required="true" maxlength="100"/>
			</div>
			<div class="row align_center">
				<input type="submit" class="btn btn-primary" name="getting_test" value="հաստատել" />
			</div>
		</form>
	</div>
</div>