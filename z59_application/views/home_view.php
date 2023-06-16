<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row">
        <h1>HighCode Certifications</h1>
        <a style="text-align: center;" href="http://albdarb.com/" target="_blank">
            <h3>Դասավանդում</h3>
        </a>

        <h2>Թեստեր</h2>
    </div>
	<div class="row">
		<?php if($tests) foreach($tests as $test):?>
			<div class="col-sm-6 col-md-4 test_blok">
				<div class="test_blok_inner">
					<h4 class="test_header"><?=$test['name']?></h4>
					<div class="test_content">
						<p><b>Ժամանակը՝ <?=$test['time']?> րոպե</b></p>
						<p><b>Նկարագրություն`</b></p>
						<p class="test_description"><?=$test['description']?></p>
					</div>
					<p><a class="btn btn-primary" href="<?=site_url('get_test/'.$test['id'])?>">Հանձնել թեստը</a></p>
				</div>
			</div>
		<?php endforeach;?>
	</div>
</div>
