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
        $('#addedCategories').append('<li>'+ escapeHtml($(this).text()) +'<input type="hidden" name="selectedCategories[]" value="'+escapeHtml($(this).text())+'"></li>');
    }
});
$('#addedCategories').on('click','li', function(){
    $(this).remove();
});

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}