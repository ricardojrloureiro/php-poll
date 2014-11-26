
$('.add-poll').click(function() {
    var e = $('<div class="from-group"> <input type="text" class="form-control" name="option[]"id="optionid[]" placeholder="Insert answer option"> </div>');
    $('.poll-options').append(e);
});