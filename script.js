document.getElementById('newPostBtn').addEventListener('click', function() {
    document.getElementById('postForm').style.display = 'block';
});

document.getElementById('postFormContent').addEventListener('submit', function(event) {
    event.preventDefault();

    var username = document.getElementById('username').value;
    var postTitle = document.getElementById('postTitle').value;
    var category = document.getElementById('category').value;
    var postContent = document.getElementById('postContent').value;

    var currentDate = new Date();
    var dateString = currentDate.toLocaleString();

    var post = `
        <div class="post">
            <p>Pseudo: ${username}</p>
            <p>Date: ${dateString}</p>
            <p>Titre: ${postTitle}</p>
            <p>Catégorie: ${category}</p>
            <p>Contenu: ${postContent}</p>
            <button class="likeBtn">Like</button>
        </div>
    `;

    document.getElementById('posts').insertAdjacentHTML('beforeend', post);

    document.getElementById('postFormContent').reset();

    document.getElementById('postForm').style.display = 'none';

    var likeBtns = document.querySelectorAll('.likeBtn');
    likeBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var likes = parseInt(this.dataset.likes || 0);
            likes++;
            this.innerText = 'Like (' + likes + ')';
            this.dataset.likes = likes;
        });
    });
});
