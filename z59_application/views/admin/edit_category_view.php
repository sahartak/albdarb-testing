<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row"><h1 class="page_title">Խմբագրել Թեստի Թեմաները</h1><br /></div>

	<div class="row">
	<?php echo validation_errors();?>
	</div>

	<?php echo form_open('',array('id' => 'category_form')); ?>

		<div id="edit_category_block">
		<?php $i=1; foreach($categories as $cat):?>
			<div class="row">
				<div class="col-sm-6">
					<div class="row td_options">
						<div class="col-xs-11"><input type="text" class="form-control" value="<?=$cat['name']?>" placeholder="Թեմայի Անվանումը" required="true" id="c_<?=$cat['id']?>" /></div>
						<div class="col-xs-1"><a class="glyphicon glyphicon-trash trash_button delete_cat" href="#<?=$cat['id']?>" title="Ջնջել"></a></div>
					</div>
				</div>
			</div>
		<?php $i++; endforeach;?>
		</div>
		<input type="hidden" id="test_id" value="<?=$test_id?>"/>
		<div class="row">
			<div class="col-sm-6">
				<button class="btn btn-warning" id="add_new_cat">Ավելացնել նոր թեմա</button>
			</div>
		</div>
		<div class="row align_center">
			<a class="btn btn-success" href="<?=site_url('admin/view_test/'.$test_id)?>">Անցնել առաջ</a>
		</div>
		

	</form>

	<div class="hidden" >
		<div class="row" id="add_cat_template">
			<div class="col-sm-6">
				<div class="row td_options">
					<div class="col-xs-11"><input type="text" class="form-control" value="" placeholder="Թեմայի Անվանումը" required="true" /></div>
					<div class="col-xs-1"><a class="glyphicon glyphicon-trash trash_button delete_cat" href="#" title="Ջնջել"></a></div>
				</div>
			</div>
		</div>
	</div>
</div>

