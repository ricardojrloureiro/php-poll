$( document ).ready(function() {

    var BASE_URL = "http://ltw.app:8000/";

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
                var str = e.target.result + "";
                if ( str.match("^data:video/webm")) 
                {
                    $('#imagePreview').replaceWith('<video width="500" id="imagePreview" controls><source src="' + e.target.result + '" type="video/webm"></video>');
                }
                else if(str.match("^data:video/ogg"))
                {
                    $('#imagePreview').replaceWith('<video width="500" id="imagePreview" controls><source src="' + e.target.result + '" type="video/ogg"></video>');
                }
                else if(str.match("^data:video/mp4") )
                {
                  $('#imagePreview').replaceWith('<video width="500" id="imagePreview" controls><source src="' + e.target.result + '" type="video/mp4"></video>');
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
        $.getJSON(BASE_URL + "index.php?page=availableUsername&username=" + $("#usernameRegister").val(),
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

    var searchResults = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: BASE_URL + 'index.php?page=searchApi&query=%QUERY'
    });

    searchResults.initialize();

    $('#search').typeahead(null, {
        displayKey: 'value',
        source: searchResults.ttAdapter()
    });

});