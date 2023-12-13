src="../includes/jquery-3.6.4.min.js"
src="../includes/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"
$(document).ready(function () {
    $('.grid-item').click(function () {
        var MediaID = $(this).find('.overlay').data('media');
        var imgSrc = $(this).find('img').attr('src');
        var username = $(this).find('.overlay').data('username');
        var description = $(this).find('.overlay').data('desc');
        var title = $(this).find('.overlay').data('title');
        var avatar = $(this).find('.overlay').data('avatar');
        var hiddenMediaID = $(this).find('.overlay').data('MediaID');

        $('#modalImage').attr('src', imgSrc);
        $('#modalUsername').text(username);
        $('#modalTitle').text(title);
        $('#modalDescription').text(description);
        $('#modalAvatar').attr('src', avatar);
        $('#imageModal').modal('show');
        $('#hiddenMediaID').val(MediaID);
        $('#likeProfile').val(MediaID);
        $('#likeMedia').val(MediaID);

        console.log("Media ID: ", MediaID);
        console.log("værdi sat: ", $('#hiddenInputMediaID').val());

        var hiddenInputMediaID = $(this).find('.overlay').data('MediaID');
        $('#hiddenInputMediaID').val(hiddenInputMediaID);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    document.getElementById("comments").innerHTML = this.responseText;
                } else {
                    console.error("Error loading comments:", this.status, this.statusText);
                }
            }
        };
        xmlhttp.open("GET", "../logic/getComments.inc.php?MediaID=" + MediaID, true);
        xmlhttp.send();
    });

    // ... resten af din eksisterende kode ...

    // Når brugeren klikker på "Like"
    $('.like-button').on('click', function () {
        handleLikeOrDislike(1, $(this), '../logic/like.php');
    });

    // Når brugeren klikker på "Dislike"
    $('.dislike-button').on('click', function () {
        handleLikeOrDislike(-1, $(this), '../logic/like.php');
    });

    function handleLikeOrDislike(action, $button, actionFile) {
        var postid = $button.closest('.likeButtons').data('media-id');
        var likesCount = $button.closest('.likeButtons').data('likes');
        $.ajax({
            url: actionFile,
            type: 'post',
            data: {
                'like_action': action,
                'postid': postid
            },
            success: function (response) {
                $('#imageModal').find('.likes_count_modal').text(response + ' likes');
                $button.closest('.likeButtons').data('likes', response);
            }
        });
    }
});

document.addEventListener("click", function (e) {
    if (e.target.classList.contains("gallery-item")) {
        const src = e.target.getAttribute("src");
        document.querySelector(".modal-img").src = src;
        const myModal = new bootstrap.Modal(document.getElementById('gallery-modal'));
        myModal.show();
    }
});

