var popup = null;
$(document).ready(function() {
	popup = $('.popup').detach();
	$('form').submit(function() {
		$('#submit').trigger('click');
		return false;
	});
	$('#submit').click(function() {
		var task = $('#task').val().trim();
		if ( task.length == 0 ) {
			if ( $('.popup').length == 0 ) {
				$('#task').after(popup.clone());
				$('.popup').slideDown();
			}
		} else {
			var data = {type:{}, values:{}};
			data['type'] = 'add_task';
			data['values']['title'] = task;
			var data = JSON.stringify(data);
			$.ajax({
				type: 'POST',
				url: 'process.php',
				data: 'data='+data,
				success: function(result) {
					$('#task').val('');
					$('#table-content').html(result);
				},
				error: function() {
					alert('Connection Error!');
				}
			});
		}
	});
	$(document).on('click', '.pause', function() {
		update(this);
	});
	$(document).on('click', '.resume', function() {
		update(this);
	});
	$(document).on('click', '.stop', function() {
		update(this);
	});
	function update(element) {
		var data = {type:{}, values:{}};
		data['type'] = $(element).attr('actionType');
		data['values']['id'] = $(element).attr('serial');
		var data = JSON.stringify(data);
		$.ajax({
			type: 'POST',
			url: 'process.php',
			data: 'data='+data,
			success: function(result) {
				$('#task').val('');
				$('#table-content').html(result);
			},
			error: function() {
				alert('Connection Error!');
			}
		});
	}
});