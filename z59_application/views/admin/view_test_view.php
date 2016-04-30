<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container"><br />

	<div class="row"><h1 class="page_title">Թեստ N<?=$test['id']?> &laquo;<?=$test['name']?>&raquo;</h1></div>

	<div class="row">
		<?php echo form_open();?>
			<div class="row">
				<h3>Թեստը հանձնելիս տրվող հարցերի քանակը` <span id="questions_count"><?=$test['total_sum']?></span></h3>
				<h3>Թեստի հնարավոր առավելագույն միավորը` <span id="test_max_point"><?=$test['total_sum'] * $test['point']?></span> միավոր</h3>
			</div>
			<input type="hidden" id="token_hash" value="<?=$this->security->get_csrf_hash()?>" />
			<input type="hidden" id="token_name" value="<?=$this->security->get_csrf_token_name()?>" />
			<input type="hidden" id="test_id" value="<?=$test['id']?>" />
			<?php if(!empty($test['difficulty'])): 
				foreach($test['difficulty'] as $difficulty): ?>
				<div class="col-sm-4 align_center">
					<div class="col-sm-12"><label><?=$difficulty['difficulty_name']?> հարցերի քանակը </label></div>
					<div class="row">
						<div class="col-sm-12">
							<select name="diff_<?=$difficulty['id']?>_total" class="form-control questions_counts">
							<?php for($i=0; $i<=$difficulty['total']; $i++):?>
								<option value="<?=$i?>" <?php if($i==$test['diff_'.$difficulty['id'].'_total']) echo 'selected';?>><?=$i?></option>
							<?php endfor;?>    
							</select>
						</div>
					</div>
				</div>
			<?php endforeach;?>
			<?php else:?>
					<p>Այս թեստի համար դուք չունեք հարցեր: <a href="<?=site_url('admin/add_question/'.$test['id'])?>">Ավելացնել հարց</a></p>
			<?php endif;?>
		</form>
	</div><br />
		
	<div class="row table-responsive">
		<table class="table-bordered table-condensed table-striped table-hover" width="100%">
			<tr>
				<th>ID</th>
				<th>Անվանումը</th>
				<th>Հասանելիություն</th>
				<th>Ստեղծման ամսաթիվ</th>
				<th>Հարցի միավորը</th>
				<th>Քանի հոգի է հանձնել</th>
				<th>Հարցերի քանակը</th>
				<th>Ամենաբարձր բալը</th>
				<th>Ամենացածր բալը</th>
				<th>Կարգավիճակ</th>
			</tr>
			<tr>
				<td><?=$test['id']?></td>
				<td><?=$test['name']?></td>
				<td><?php echo $test['is_public'] ? 'Բոլորին' : 'Գաղտնաբառով'?></td>
				<td><?=date('d.m.Y',strtotime($test['created']))?></td>
				<td><input type="number" class="form-control align_center" id="test_point" value="<?=$test['point']?>" min="0.5" step="0.5" /></td>
				<td><?php echo isset($statistics['total'])? $statistics['total'] : '-'?></td>
				<td><?=count($test['questions'])?></td>
				<td><?php echo isset($statistics['max_point'])? $statistics['max_point'] : '-'?></td>
				<td><?php echo isset($statistics['min_point'])? $statistics['min_point'] : '-'?></td>
				<td>
					<select class="form-control" id="is_open">
						<option value="0">Սևագիր</option>
						<option value="1" <?php if($test['is_open']) echo 'selected'; ?>>Հրապարակված</option>
					</select>
				</td>
			</tr>
		</table>
	</div>
	<div class="row"><h2 class="page_title">Թեստի հարցերը. <a href="<?=site_url('admin/add_question/'.$test['id'])?>">Ավելացնել հարց</a></h2></div>
	<div class="row table-responsive">
		<table class="table-bordered  table-condensed table-striped table-hover table_datatable" width="100%">
			<thead>
				<tr>
					<th>Հ/հ</th>
					<th>ID</th>
					<th>Հարցը</th>
					<th>Ճիշտ պատասխաններ<br />նշելու քանակը</th>
					<th>Ստեղծման ամսաթիվ</th>
					<th>Թեման</th>
					<th>Բարդությունը</th>
					<th>Ստեղծման ամսաթիվը</th>
					<th>Պատասխաններ<br />(Կանաչ գույնով նշված է ճիշտ պատասխանը)</th>
					<th>Գործողություններ</th>
				</tr>
			</thead>
			<tbody>
			<?php $i=1; foreach($test['questions'] as $question):?>
				<tr>
					<td><?=$i++?></td>
					<td><?=$question['id']?></td>
					<td><?=$question['question']?></td>
					<td><?=$question['answer_mode'] ? '1 ից ավելի պատասխաններ' : '1 պատասխան'?></td>
					<td><?=date('d.m.Y',strtotime($question['created']))?></td>
					<td><?=$question['category_name']?></td>
					<td><?=$question['difficulty_name']?></td>
					<td><?=date('d.m.Y',strtotime($question['created']))?></td>
					<td>
						<ul>
							<?php foreach($question['answers'] as $answer):?>
								<li<?php if($answer['is_right']) echo ' class="green"';?>><?=$answer['answer']?></li>
							<?php endforeach;?>
						</ul>
					</td>
					<td class="td_options">
						<a href="<?php echo site_url('admin/edit_question/'.$question['id']);?>" title="Խմբագրել" class="glyphicon glyphicon-edit edit_button"></a>
						<a href="<?php echo site_url('admin/delete_question/'.$question['id']);?>" onclick="return confirm('Համոզվա՞ծ եք, որ ցանկանում եք ջնջել այս հարցը')" class="glyphicon glyphicon-trash trash_button" title="Ջնջել" ></a>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>