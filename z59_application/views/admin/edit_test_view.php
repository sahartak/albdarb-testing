<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row"><h1 class="page_title">Խմբագրել Թեստը</h1><br /></div>
	<?php 
		echo validation_errors();
		echo form_open();
	?>
		<div class="row">
			<div class="col-sm-6">
				<input type="text" name="name" class="form-control" value="<?php echo set_value('name', $test['name'])?>" placeholder="Թեստի անվանումը" maxlength="255" required="true" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><label for="is_public">Թեստը հասանելի՞ է բոլորին</label></div>
			<div class="col-sm-2">
				<select class="form-control" name="is_public" id="is_public">
					<option value="1">այո</option>
					<option value="0" <?php if(set_value('is_public', $test['is_public'])==='0') echo 'selected'?>>ոչ</option>
				</select>
			</div>
		</div>
		<div class="row" id="test_pass">
			<div class="col-md-12"><label for="password">Թեստի գաղտնաբառը</label></div>
			
			<div class="col-sm-6">
				<input type="password" name="password" value="" id="password" class="form-control" maxlength="255" />
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12"><input type="submit" class="btn btn-success" value="հաստատել և անցնել առաջ" /></div>
		</div>
	</form>
</div>