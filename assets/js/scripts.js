function escapeHtml(text) {
	var map = {
	'<': '&lt;',
	'>': '&gt;',
	'"': '&quot;',
	"'": '&#039;'
	};
	var new_text = text.replace(/[<>"']/g, function(m) { return map[m]; });
	new_text = new_text.replace(/&lt;pre&gt;/, '<pre>');
	new_text = new_text.replace(/&lt;\/pre&gt;/, '</pre>');
	return new_text;
}
$(document).ready(function() {

	$('.open_question_btn').click(function() {
		var open_id = $(this).attr('data-open');
		$('.current_question').css('display', 'none').removeClass('current_question');
		$('#quesrion_blok_'+open_id).fadeIn().addClass('current_question');
		return false;
	});

	$('.answers_bloks .passing_input').change(function() {
	   var question_id = parseInt($(this).attr('data-question'));
	   var answer = [];
	   $('.question_'+question_id+':checked').each(function(){
		   answer.push(parseInt($(this).val()));
	   });
	   $.ajax({
		   type: 'POST',
		   url: '/send_answer',
		   data: {'question_id':question_id, 'answer':answer, 'csrf_albdarb_testing_name':$("input[name='csrf_albdarb_testing_name']").val()},
		   success: function(data){
			   $("input[name='csrf_albdarb_testing_name']").val(data);
		   }
	   });
	});


	var test_time  = parseInt($('#test_time').val());
	if(test_time > 0) {
		
		$('#quesrion_blok_1').fadeIn().addClass('current_question');
		var clock;
		clock = $('.clock').FlipClock(60 * test_time, {
			countdown: true,
			callbacks: {
				stop: function() {
					window.location.href = '/end_test';
				}
			}
		});
		$('.test_header').each(function() {
			var text = $(this).html();
			text = escapeHtml(text);
			$(this).html(text);
		});

	}

	$('#course').change(function() {
		if($(this).val() === '0') {
			$('#course_name_block').removeClass('hidden').find('#course_name').prop('required', true);
		} else {
			$('#course_name_block').addClass('hidden').find('#course_name').prop('required', false);
		}
	});

});

function noselect() {return false;}
	document.ondragstart = noselect;
    document.onselectstart = noselect;
    document.oncontextmenu = noselect;

document.onkeypress = function (event) {
	event = (event || window.event);
	if (event.keyCode == 123) {
		return false;
	}
}
document.onmousedown = function (event) {
	event = (event || window.event);
	if (event.keyCode == 123) {
		return false;
	}
}
document.onkeydown = function (event) {
		event = (event || window.event);
		if (event.keyCode == 123 ||
		(event.ctrlKey &&
			(event.keyCode === 67 ||
			 event.keyCode === 86 ||
			 event.keyCode === 85 ||
			 event.keyCode === 117))
		) {
			return false;
		}
}