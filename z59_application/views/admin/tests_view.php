<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container"><br />
	<div class="row table-responsive">
	<?php if(!$tests):?>
		<h2>Թեստերը դեռ չկան: <a href="<?php echo site_url('admin/create_test');?>">Ավելացնել Թեստ</a></h2>
	<?php else:?>
		<table class="table-bordered table-condensed table-striped table-hover table_datatable" width="100%" >
			<thead>
				<tr>
					<th>Հ/հ</th>
					<th>ID</th>
					<th>Անվանումը</th>
					<th>Հասանելիություն</th>
					<th>Ստեղծման ամսաթիվ</th>
					<th>Գործողություններ</th>
				</tr>
			</thead>
			<tbody>
			<?php $i=1; foreach($tests as $test):?>
				<tr>
					<td><?=$i++?></td>
					<td><?=$test['id']?></td>
					<td><?=$test['name']?></td>
					<td><?php echo $test['is_public'] ? 'Բոլորին' : 'Գաղտնաբառով'?></td>
					<td><?=date('d.m.Y',strtotime($test['created']))?></td>
					<td class="td_options">
						<a href="<?php echo site_url('admin/test_results/'.$test['id']);?>" class="glyphicon glyphicon-list-alt" title="Թեստի արդյունքները"></a>
						<a href="<?php echo site_url('admin/view_test/'.$test['id']);?>" class="glyphicon glyphicon-search" title="Դիտել Թեստը"></a>
						<a href="<?php echo site_url('admin/edit_test/'.$test['id']);?>" title="Խմբագրել" class="glyphicon glyphicon-edit edit_button"></a>
						<a href="<?php echo site_url('admin/delete_test/'.$test['id']);?>" class="glyphicon glyphicon-trash trash_button" title="Ջնջել" onclick="return confirm('Համոզվա՞ծ եք, որ ցանկանում եք ջնջել <?=$test['name']?> թեստը')"></a>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	<?php endif;?>
	</div>
</div>