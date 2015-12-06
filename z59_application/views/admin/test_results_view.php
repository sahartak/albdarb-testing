<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container"><br />
    
	<div class="row"><h1 class="page_title">Թեստ N<?=$test_info['id']?> &laquo;<?=$test_info['name']?>&raquo;</h1></div>

		
	<div class="row">
		<table class="table-bordered table-condensed table-striped table-hover" width="100%">
			<tr>
				<th>Հ/հ</th>
				<th>Անուն</th>
				<th>Ազգանուն</th>
				<th>Հայրանուն</th>
				<th>Խումբ</th>
				<th>Ստացած արդյունք</th>
                <th>Ստացած <br />արդյունք%</th>
				<th>Հնարավոր արդյունք</th>
				<th>Սկսվել է</th>
				<th>Ավարտվել է</th>
				<th>Տևողություն</th>
                <th>IP</th>
                <th>Գործողություններ</th>
			</tr>
        <?php $i=1; foreach($test_results as $result):?>
            <tr>
                <td><?=$i++?></td>
                <td><?=$result['first_name']?></td>
                <td><?=$result['last_name']?></td>
                <td><?=$result['father_name']?></td>
                <td><?=$result['group'] ? $result['group'] : 'Այլ'?></td>
                <td><?=$result['point']?></td>
                <td><?=round($result['point']*100/$result['max_point'])?></td>
                <td><?=$result['max_point']?></td>
                <td><?=date('d.m.Y H:i:s', strtotime($result['start_time']))?></td>
                <td><?=date('d.m.Y H:i:s', strtotime($result['end_time']))?></td>
                <td><?=$this->test_model->get_times_interval($result['start_time'], $result['end_time'])?></td>
                <td><?=$result['ip']?></td>
                <td class="td_options">
                    <a href="<?php echo site_url('admin/test_result/'.$result['id']);?>" target="_blank" class="glyphicon glyphicon-search" title="Դիտել մանրամասն"></a>
                    <a href="<?php echo site_url('admin/delete_test_result/'.$result['id']);?>" class="glyphicon glyphicon-trash trash_button" title="Ջնջել" onclick="return confirm('Համոզվա՞ծ եք, որ ցանկանում եք ջնջել')"></a>
                </td>
            </tr>
        <?php endforeach;?>
		</table>
	</div>
</div>