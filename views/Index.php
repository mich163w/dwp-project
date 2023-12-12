<?php

spl_autoload_register(function ($class) {
    include_once "../classes/" . $class . ".php";
});


date_default_timezone_set('Europe/Copenhagen');
require("../logic/createComment.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<?php require("../includes/header.php"); ?>
<body>
    <?php require("../includes/menu.php"); ?>
    <div class="content">
        <button id="myBtn">+</button>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <form method="post" id="modalform" action="../logic/mediaInsert.php" enctype="multipart/form-data">
                    <div class="modalbox">
                        <div class="modalLeft">
                            <input class="uploadBtn" type="file" name="picture">
                        </div>
                        <div class="modalRight">
                            <label for="Title">Title</label>
                            <input class="mTitle" type="text" name="mediaTitle">
                            <label for="Description">Description</label>
                            <input class="mDesc" type="text" name="mediaDesc" rows="10" col="25">
                            <input type="submit" class="submitBtn" name="submit" value="Submit" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="imageModal">
        <?php
        $sql = "SELECT Profile.ProfileID, Profile.Username, Profile.Fname, Profile.Lname, Profile.Avatar, Media.URL, Media.mediaTitle, Media.mediaDesc, Media.MediaID, (SELECT COUNT(*) FROM Likes WHERE Likes.MediaLikeFK = Media.MediaID) AS 'Likes',(CASE WHEN EXISTS (SELECT 1 FROM Likes WHERE Likes.MediaLikeFK = Media.MediaID AND Likes.ProfileLikeFK = Profile.ProfileID) THEN 1 ELSE 0 END) AS 'HasLiked'
       FROM
           Profile
       JOIN
           Media ON Profile.ProfileID = Media.MediaProfileFK;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-3 grid-item">';
                echo '<img id="imageDisplay" height="576px" src="' . $row["URL"] . '" alt="' . '">';
                echo '<div class="overlay" data-toggle="modal" data-target="#imageModal" data-media="' . $row['MediaID'] . '" data-username="' . $row['Username'] . '" data-desc="' . $row['mediaDesc'] . '" data-title="' . $row['mediaTitle'] . '" data-avatar="' . $row['Avatar'] . '">';
                echo "Likes: " . $row['Likes'];
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "0";
        }
        $conn->close();
        ?>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popupLeft">
                        <img src="" class="img-fluid" id="modalImage" alt="image" width="170px" height="300px" ;>
                    </div>
                    <div class="popupRight">
                        <div class="imgProfileDisplay">
                            <img src="" class="img-fluid" id="modalAvatar" alt="avatar" width="30px" height="30px" ;>
                            <span id="modalUsername"></span>
                        </div>
                        <h5 id="modalTitle"></h5>
                        <p id="modalDescription">
                        <div class="likeButtons">
                            <form action="../logic/like.php" method="post">
                                <input type="hidden" id='likeMedia' name="MediaLikeFK" value="3"> <!-- Replace with the actual profile ID -->
                                <input type="hidden" id='likeProfile' name="ProfileLikeFK" value="3"> <!-- Replace with the actual media ID -->
                                <button class="like-button" type="submit" name="like_action" value="Like">✓</button>
                            </form>
                            <form action="../logic/like.php" method="post">
                                <input type="hidden" id='likeMedia' name="MediaLikeFK" value="3"> <!-- Replace with the actual profile ID -->
                                <input type="hidden" id='likeProfile' name="ProfileLikeFK" value="3"> <!-- Replace with the actual media ID -->
                                <button class="dislike-button" type="submit" name="like_action" value="dislike">✕</button>
                            </form>
                        </div>
                        <?php
                        require("../logic/getComments.inc.php");
                        //$MediaID = 3;
                        echo "<form method='POST' action='../logic/createComment.inc.php'>
                            <input type='hidden' name='MediaID' id='hiddenMediaID' value='3'>
                            <input type='hidden' name='ProfileFK' value='Anonymous'>
                            <input type='hidden' name='dato' value='" . date('Y-m-d H:i:s') . "'>
                            <textarea class='CommentText' name='CommentText'></textarea>
                            <button type='submit' class='commentSubmit' name='commentSubmit'>Comment</button>
                        </form>";
                        ?>
                        <span id="comments"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require("../includes/footer.php"); ?>
    <script>
        $(document).ready(function() {
            $('.grid-item').click(function() {
                var MediaID = $(this).find('.overlay').data('media')
                var imgSrc = $(this).find('img').attr('src');
                var username = $(this).find('.overlay').data('username'); //Eksempel på hvad disse gør: opretter en variabel ved navn "username". Her bruges jQuery for at finde et element med klassen ".overlay" i det element, der udløser begivenheden. Derefter bruges .data('username') til at få værdien af attributten 'username' fra dette element. Denne værdi bliver gemt i variablen "username".
                var description = $(this).find('.overlay').data('desc');
                var title = $(this).find('.overlay').data('title');
                var avatar = $(this).find('.overlay').data('avatar');
                var hiddenMediaID = $(this).find('.overlay').data('MediaID');
                $('#modalImage').attr('src', imgSrc);
                $('#modalUsername').text(username); //Finder et HTML-element med id'et 'modalUsername'. Vi indstiller teksten af dette element til værdien af variablen "username", der vises i modalboksen
                $('#modalTitle').text(title);
                $('#modalDescription').text(description);
                $('#modalAvatar').attr('src', avatar);
                $('#imageModal').modal('show');
                $('#hiddenMediaID').val(MediaID);
                $('#likeProfile').val(MediaID);
                $('#likeMedia').val(MediaID);
                console.log("Media ID: ", MediaID)
                console.log("værdi sat: ", $('#hiddenInputMediaID').val())
                var hiddenInputMediaID = $(this).find('.overlay').data('MediaID');
                $('#hiddenInputMediaID').val(hiddenInputMediaID);
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("comments").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "../logic/getComments.inc.php?MediaID=" + MediaID, true);
                xmlhttp.send();
            });
        });
        // Get the modal
        var modal = document.getElementById("myModal");
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        // When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        $(document).ready(function() {
            // Når brugeren klikker på "Like"
            $('.like-button').on('click', function() {
                handleLikeOrDislike(1, $(this), '../logic/like.php');
            });
            // Når brugeren klikker på "Dislike"
            $('.dislike-button').on('click', function() {
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
                    success: function(response) {
                        // Opdater likes-tællingen i modalen
                        $('#imageModal').find('.likes_count_modal').text(response + ' likes');
                        // Opdater likes-tællingen i overlay-elementet
                        $button.closest('.likeButtons').data('likes', response);
                    }
                });
            }
        });
    </script>
</body>
</html>
<style>
    .CommentText {
        overflow: auto;
        resize: vertical;
        width: 95%;
    }
    .commentSubmit {
        background-color: #DDB3B3;
        border-radius: 10px;
        margin-bottom: 5%;
        height: 31px;
        color: white;
        border: none;
    }
    .likeButtons {
        display: flex;
        margin-bottom: 2%;
        gap: 1%
    }
    .like-button {
        background-color: #DDB3B3;
        border-radius: 10px;
        height: 22px;
        width: 30px;
        color: black;
        font-size: 12px;
    }
    .dislike-button {
        background-color: #DDB3B3;
        border-radius: 10px;
        height: 22px;
        width: 30px;
        color: black;
        font-size: 12px;
    }
</style>