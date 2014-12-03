function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}

$( document ).ready(function() {


    $('body').on('change', '#poll-options input:last', function() {
        var e = $('<div class="form-group" > <input type="text" class="form-control" name="option[]" id="optionid[]" placeholder="Insert answer option"><button type="button" id="removable" class="buttRemove">Remove</button></div>');
        $('#poll-options').append(e);

        $('.buttRemove').off('click').on('click', function (ev){ 
             ev.preventDefault();    
            $(ev.target).parent().remove();
        });

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
               if(endsWith(e.target.result,".webm") )
                {
                    $('#imagePreview').parent().append('<video width="500" id="imagePreview" controls><source src="' + e.target.result + '" type="video/webm"></video>');
                }
                else if(endsWith(e.target.result,".ogg") )
                {
                    $('#imagePreview').append('<video width="500" id="imagePreview" controls><source src="' + e.target.result + '" type="video/ogg"></video>');
                }
                else if(endsWith(e.target.result,".mp4") )
                {
                  $('#imagePreview').append('<video width="500" id="imagePreview" controls><source src="' + e.target.result + '" type="video/mp4"></video>');
                }
                else
                {
                     $('#imagePreview').replaceWith('<img id="imagePreview" src="' + e.target.result + '"  width="500">');
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function(){
        readURL(this);
    });

    $("#usernameRegister").change(function() {
        $.getJSON("http://ltw.app:8000/index.php?page=availableUsername&username=" + $("#usernameRegister").val(),
            function(data) {
                if(! data.valid)
                {
                    $("#usernameRegister").css({"background-color": "rgb(255,50,50)", "color": "#FFF"});
                    $("#registerButton").attr("disabled", true);
                } else {
                    $("#usernameRegister").css({"background-color": "rgb(255,255,255)", "color": "#000"});
                    $("#registerButton").attr("disabled", false);
                }
        }
        );
    });

});