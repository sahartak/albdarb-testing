$(document).ready(function() {

	$('#is_public').change(function() {
		var test_pass = $('#test_pass');
		var password = $('#password');
		if($(this).val() == 1 ) {
			password.removeAttr('required');
			password.val('');
			test_pass.fadeOut();
		} else {
			password.attr('required','required');
			test_pass.fadeIn();
		}
	});

	$('#is_public').trigger('change');

	$('.table_datatable').dataTable({
		language: {
			"emptyTable":     "Տվյալներ Չկան",
			"info":           "Ցույց են տրված _START_ -ից մինչև _END_ -րդ տողերը ՝ ընդհանուր _TOTAL_ տողից",
			"infoFiltered":   "(ֆիլտրված է ընդհանուր _MAX_ տողերից)",
			"lengthMenu":     "Ցույց տալ _MENU_ տող",
			"loadingRecords": "Loading...",
			"processing":     "Processing...",
			"search":         "Որոնում:",
			"zeroRecords":    "Արդյունքներ չկան",
			"paginate": {
				"first":      "Առաջին",
				"last":       "Վերջին",
				"next":       "Հաջորդը",
				"previous":   "Նախորդը"
			}
		},
		dom: 'lBfrtip',
		buttons: [
			{
				extend: 'print',
				exportOptions: {
					columns: ':visible'
				}
			},
			'colvis',
		]
		/*columnDefs: [ {
			targets: -1,
			visible: false
		} ]*/
	});

	$('#qty').change(function() {
		var answers_count = 0;
		var html = '';
		var qty = $(this).val();
		if(qty) {
			var answer_mode = $('#answer_mode').val();
			var text = $('#one_right_answer_template').html();
			var temp = $('#temp_answer');
			for(var i=0; i<qty; i++) {
				answers_count++;
				temp.html(text);
				temp.find('textarea').attr('name', 'answer_'+answers_count);
				temp.find('input.answer_point').attr('name', 'point_'+answers_count);
				temp.find('input.is_right').attr('value', answers_count);
				html += temp.html();
				temp.html('');
			}
			$('#answers_block').css('display', 'none').html(html).fadeIn();
		}
		
	});

	$('#answer_mode').change(function() {
		var mode = $(this).val();
		if(mode == 1) {
			$('input.is_right').attr('type', 'checkbox');
			$('input.is_right').attr('name', 'is_right[]');
			$('input.is_right').removeAttr('required');
		} else {
			$('input.is_right').attr('type', 'radio');
			$('input.is_right').attr('name', 'is_right');
			$('input.is_right').attr('required', 'true');
		}
	});

	$('#answer_mode').trigger('change');

	$('.submit_button').click(function() {
		var answer_mode = $('#answer_mode').val();
		if(answer_mode == 1) {
			if(! $('form .is_right:checked').length) {
				alert('Հարցը պետք է ունենա գոնե 1 ճիշտ պատասխան');
				return false;
			}
		}
		var mode = $(this).attr('data-mode');
		$('#create_mode').val(mode);
		$('#submit_form').trigger('click');
		return false;
	});

	$('#category_count').change(function() {
		var qty = $(this).val();
		var html = '';
		if(qty) {
			for(var i=1; i<=qty; i++) {
				html += '<div class="row"><div class="col-sm-6"><input type="text" name="category_'+ i +'" class="form-control" placeholder="Թեմայի Անվանումը" required /></div></div>';
			}
			$('#category_block').css('display', 'none').html(html).fadeIn();
		}
	});

	$('#edit_category_block').on('click', '.delete_cat', function() {
		if(confirm('Համոզվա՞ծ եք, որ ցանկանում եք ջնջեք այս թեման')) {
			var cat_id = parseInt($(this).attr('href').substr(1));
			if(cat_id) {
				$.ajax({
					type: 'POST',
					url: '/admin_ajax/delete_cat',
					data: {'cat_id':cat_id, 'csrf_albdarb_testing_name':$("input[name='csrf_albdarb_testing_name']").val()},
					success: function(data){
						$("input[name='csrf_albdarb_testing_name']").val(data);
					}
				});
			}
			$(this).closest('.row').parent().parent().remove();
		}
		return false;
	});

	$('#edit_category_block').on('change', ':text', function() {
		var text = $(this).val();
		var cat = $(this);
		if(text != '') {
			var cat_id = $(this).attr('id');
			if(cat_id) {
				cat_id = parseInt(cat_id.substr(2));
			} else {
				cat_id = 0;
			}
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '/admin_ajax/add_update_cat',
				data: {'cat_id':cat_id, 'name':text, 'csrf_albdarb_testing_name':$("input[name='csrf_albdarb_testing_name']").val(), 'test_id':$('#test_id').val()},
				success: function(data) {
					if(data.response) {
						cat.attr('id', 'c_'+data.response);
						cat.closest('.td_options').find('.delete_cat').attr('href', '#'+data.response);
					}
					$("input[name='csrf_albdarb_testing_name']").val(data.secure);
					alert('Հաջողությամբ թարմացվեց!');
				}                
			});
		}
	});

	$('#answers_block').on('change', ':checkbox.is_right', function() {
		
	   if(this.checked) { 
		   $(this).parent().parent().find('.hidden').removeClass('hidden');
	   } else {
			$(this).parent().parent().find('.answer_point').val(0).parent().addClass('hidden');
	   }
	});


	$('#add_new_cat').click(function() {
		$('#add_cat_template').clone().removeAttr('id').appendTo('#edit_category_block');
		return false;
	});

	$('.questions_counts').change(function() {
		var total = $(this).val();
		var name = $(this).attr('name');      
		$.ajax({
			type: 'POST',
			url: '/admin_ajax/update_question_total',
			data: {'total':total, 'csrf_albdarb_testing_name' : $('#token_hash').val(), 'test_id':$('#test_id').val(), 'field':name},
			success: function(data) {
				$('#token_hash').val(data);
			}                
		});
		var sum = 0;
		$('.questions_counts').each(function() {
		   sum += parseInt($(this).val()); 
		});
		$('#questions_count').text(sum);
		change_max_point();
	});

	$('#is_open').change(function() {
		var status = $(this).val();
		if(status == 1) {
			if(parseInt($('#questions_count').text()) < 1) {
				alert('Դուք չեք նշել հարցերի քանակը');
				$('#is_open option[value=1]').removeAttr('selected');
				return false;
			}
		}
		$.ajax({
			type: 'POST',
			url: '/admin_ajax/update_test_status',
			data: {'csrf_albdarb_testing_name' : $('#token_hash').val(), 'test_id':$('#test_id').val(), 'status':status},
			success: function(data) {
				$('#token_hash').val(data);
			}                
		});
	});

	$('#test_point').change(function() {
		var point = $(this).val();
		$.ajax({
			type: 'POST',
			url: '/admin_ajax/update_test_point',
			data: {'csrf_albdarb_testing_name' : $('#token_hash').val(), 'test_id':$('#test_id').val(), 'point':point},
			success: function(data) {
				$('#token_hash').val(data);
			}                
		});
		change_max_point();
	});

	function change_max_point() {
		var max_point = parseFloat($('#test_point').val()) * parseInt($('#questions_count').text());
		$('#test_max_point').text(max_point);
	}


});