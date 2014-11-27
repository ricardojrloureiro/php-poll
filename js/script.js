$( document ).ready(function() {


	$('body').on('change', '#poll-options input:last', function() {
		var e = $('<div class="form-group"> <input type="text" class="form-control" name="option[]" id="optionid[]" placeholder="Insert answer option"> </div>');
		$('#poll-options').append(e);
	
	});

});
