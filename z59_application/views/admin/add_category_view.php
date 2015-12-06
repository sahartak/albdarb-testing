<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row"><h1 class="page_title">Ավելացնել Թեստի Թեմաները</h1><br /></div>

	<div class="row">
	<?php echo validation_errors();?>
	</div>

	<?php echo form_open('',array('id' => 'category_form')); ?>

	<div class="row">
		<div class="col-sm-6">
				<select class="form-control" name="category_count" id="category_count" required>
					<option value="">Նշեք ավելացվող թեմաների քանակը</option>
				<?php for($i=1; $i < 51; $i++):?>
					<option value="<?=$i?>"><?=$i?></option>
				<?php endfor;?>
				</select>
		</div>
	</div>
	<div id="category_block"></div>
	<div class="row align_center">
		<input type="submit" class="btn btn-success" value="Հաստատել և անցնել առաջ" />
	</div>
</div>

