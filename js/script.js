$( document ).ready(function() {


	$('body').on('change', '#poll-options input:last', function() {
		var e = $('<div class="form-group"> <input type="text" class="form-control" name="option[]" id="optionid[]" placeholder="Insert answer option"> </div>');
		$('#poll-options').append(e);
	});

    //triggered when delete modal is about to be shown
    $('#deletePollModal').on('show.bs.modal', function(e) {
        var deleteUrl = $(e.relatedTarget).data('delete-url');

        $(e.currentTarget).find('#deleteLink').attr("href", deleteUrl);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result).fadeIn(300);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function(){
        readURL(this);
    });

});
