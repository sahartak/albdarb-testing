<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row">
		<h1 class="page_title">Ընտրեք թեստերը և հաստատեք:</h1>
		<h4>Նշված թեստերի առկա բոլոր հարցերը կավելացվեն այս թեստին: Թեստի հին հարցերը կմնան անփոփոխ</h4>
	</div>
	<?php
	echo validation_errors();
	echo form_open();
	?>

	<br /><br />

	<div class="row">
		<div class="col-sm-12"><label for="answer_mode">Ընտրեք թեստերը</label></div>
		<div class="col-sm-12">
			<?php foreach($tests as $test):?>
				<p>
					<label><input type="checkbox" name="tests[]" value="<?=$test['id']?>" /> <?=$test['name']?></label>
				</p>
			<?php endforeach?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 align_center">
			<input type="submit" class="btn btn-primary" value="Հաստատել և դիտել թեստը" />
		</div>
	</div>
	</form>
</div>

</div>