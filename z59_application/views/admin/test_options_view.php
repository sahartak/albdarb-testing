<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container"><br />
    
	<div class="row"><h1 class="page_title">Թեստ N<?=$test['id']?> &laquo;<?=$test['name']?>&raquo;</h1></div>


		<div class="row">
			<?php echo form_open();?>
				<div class="row">
					<h3>Թեստը հանձնելիս տրվող հարցերի քանակը <span id="questions_count"></span></h3>
				</div>
				<?php if(!empty($test['difficulty'])): 
					foreach($test['difficulty'] as $difficulty): ?>
					<div class="col-sm-4 align_center">
						<div class="col-sm-12"><label><?=$difficulty['difficulty_name']?> հարցերի քանակը</label></div>
						<div class="row">
							<div class="col-sm-12">
								<select name="dif_<?=$difficulty['id']?>" class="form-control">
								<?php for($i=1; $i<=$difficulty['total']; $i++):?>
									<option value="<?=$i?>"><?=$i?></option>
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
		</div>
		
		
		
		<div class="row"></div>
	</form>

	<div class="row">
		<table class="table-bordered table-condensed table-striped table-hover" width="100%">
			<tr>
				<th>ID</th>
				<th>Անվանումը</th>
				<th>Հասանելիություն</th>
				<th>Ստեղծման ամսաթիվ</th>
				<th>Քանի հոգի է հանձնել</th>
				<th>Հարցերի քանակը</th>
				<th>Ամենաբարձր բալը</th>
				<th>Ամենացածր բալը</th>
			</tr>
			<tr>
				<td><?=$test['id']?></td>
				<td><?=$test['name']?></td>
				<td><?php echo $test['is_public'] ? 'Բոլորին' : 'Գաղտնաբառով'?></td>
				<td><?=date('d.m.Y',strtotime($test['created']))?></td>
				<td>-</td>
				<td><?=count($test['questions'])?></td>
				<td>-</td>
				<td>-</td>
			</tr>
		</table>
	</div>


	<div class="row"><h2 class="page_title">Թեստի հարցերը. <a href="<?=site_url('admin/add_question/'.$test['id'])?>">Ավելացնել հարց</a></h2></div>
	<div class="row">
		<table class="table-bordered table-responsive table-condensed table-striped table-hover" width="100%">
			<tr>
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
		<?php foreach($test['questions'] as $question):?>
			<tr>
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
				<td>
					<a href="<?php echo site_url('admin/edit_question/'.$question['id']);?>" class="btn btn-primary">Խմբագրել</a><br /><br />
					<a href="<?php echo site_url('admin/delete_question/'.$question['id']);?>" onclick="return confirm('Համոզվա՞ծ եք, որ ցանկանում եք ջնջել այս հարցը')" class="btn btn-danger">Ջնջել</a>
				</td>
			</tr>
		<?php endforeach;?>
		</table>
	</div>
</div>