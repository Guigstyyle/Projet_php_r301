$(document).ready(function() {
    $(".modifyComment").click(function() {
        // Find the nearest comment container
        let commentContainer = $(this).closest(".comment");
        let formContainer = $(this).closest("form");
        // Find the comment text within the container
        let commentText = commentContainer.find("p");

        // Create a textarea element for editing
        let textarea = $("<textarea>").val(commentText.text());
        // Replace the comment text with the textarea
        commentText.replaceWith(textarea);
        // Add a "Save" button
        let saveButton = $("<button  type='submit' name='action' value='modifyComment'>").text("Save");
        $(this).replaceWith(saveButton);
        $(saveButton).click(function() {
            // Get the edited comment text from the textarea
            let editedText = textarea.val();
            console.log(editedText);

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