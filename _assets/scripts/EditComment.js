$(document).ready(function() {
    $(".modifyComment").click(function() {
        // Find the nearest comment container
        let commentContainer = $(this).closest(".comment");
        let formContainer = $(this).closest("form");
        // Find the comment text within the container
        let commentText = commentContainer.find("p");

        let searchBar = "<input type='search' class='commentUserSearch searchBar' placeholder='Utilisateur'>";
        $(searchBar).insertAfter(commentContainer.find("p"));
        $(commentContainer).on('input', '.commentUserSearch', function () {
            var query = $(this).val();
            $.ajax({
                type: 'GET',
                url: '_assets/includes/AutosuggestUser.php',
                data: { query: query },
                success: function (data) {
                    $(commentContainer).find('.userSuggestions').html(data);
                }
            });
        });
    $(commentContainer).find('.userSuggestions').on('click','li', function(){
        if ($(commentContainer).find('.addedUsers li:contains(' + $(this).text() + ')').length === 0){
            $(commentContainer).find('.addedUsers').append('<li>'+$(this).text()+'<input type="hidden" name="selectedUsers[]" value="'+$(this).text().split(' ')[0].trim()+'"></li>');
        }
    });
    $(commentContainer).find('.addedUsers').on('click','li', function(){
        $(this).remove();
    });
        // Create a textarea element for editing
        let textarea = $("<textarea>").val(commentText.text());
        // Replace the comment text with the textarea
        commentText.replaceWith(textarea);
        // Add a "Save" button
        let saveButton = $("<button  type='submit' name='action' value='modifyComment'>").text("Commenter");
        $(this).replaceWith(saveButton);
        $(saveButton).click(function() {
            // Get the edited comment text from the textarea
            let editedText = textarea.val();

            // Replace the textarea with the updated comment text
            textarea.replaceWith("<p>" + editedText + "</p");

            let hiddenInput = $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'modifiedComment')
                .val(editedText);

            // Append the hidden input to the form
            formContainer.append(hiddenInput);
        });



    });
});