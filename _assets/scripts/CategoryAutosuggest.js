$(document).ready(function () {
    $('#categorySearch').on('input', function () {
        var query = $(this).val();
        $.ajax({
            type: 'GET',
            url: '_assets/includes/AutosuggestCategory.php',
            data: {query: query},
            success: function (data) {
                $('#categorySuggestions').html(data);
            }
        });
    });
});
$('#categorySuggestions').on('click','li', function(){
    if ($('#addedCategories li:contains(' + $(this).text() + ')').length === 0){
        $('#addedCategories').append('<li>'+$(this).text()+'<input type="hidden" name="selectedCategories[]" value="'+$(this).text()+'"></li>');
    }
});
$('#addedCategories').on('click','li', function(){
    $(this).remove();
});