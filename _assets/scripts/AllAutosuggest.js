$(document).ready(function () {
    $('#searchBar').on('input', function () {
        var query = $(this).val();
        $.ajax({
            type: 'GET',
            url: '_assets/includes/AutosuggestAll.php',
            data: {query: query},
            success: function (data) {
                $('#suggestionsAll').html(data);
            }
        });
    });
});