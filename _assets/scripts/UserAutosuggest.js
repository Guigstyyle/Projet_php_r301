$(document).ready(function () {
    $('#userSearch').on('input', function () {
        var query = $(this).val();
        $.ajax({
            type: 'GET',
            url: '_assets/includes/AutosuggestUser.php',
            data: {query: query},
            success: function (data) {
                $('#userSuggestions').html(data);
            }
        });
    });
});
$('#userSuggestions').on('click','li', function(){
    if ($('#addedUsers li:contains(' + $(this).text() + ')').length === 0){
        $('#addedUsers').append('<li>'+$(this).text()+'<input type="hidden" name="selectedUsers[]" value="'+$(this).text().split(' ')[0].trim()+'"></li>');
    }
});
$('#addedUsers').on('click','li', function(){
    $(this).remove();
});