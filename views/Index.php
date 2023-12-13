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
        $sql = "SELECT 
        Profile.ProfileID, 
        Profile.Username, 
        Profile.Fname, 
        Profile.Lname, 
        Profile.Avatar, 
        Media.URL, 
        Media.mediaTitle, 
        Media.mediaDesc, 
        Media.MediaID, 
        SUM(Likes.LikeAmount) AS 'Likes',
        (CASE WHEN SUM(Likes.LikeAmount) > 0 THEN 1 ELSE 0 END) AS 'HasLiked'
    FROM
        Profile
    JOIN
        Media ON Profile.ProfileID = Media.MediaProfileFK
    LEFT JOIN
        Likes ON Media.MediaID = Likes.MediaLikeFK
    GROUP BY
        Profile.ProfileID, 
        Profile.Username, 
        Profile.Fname, 
        Profile.Lname, 
        Profile.Avatar, 
        Media.URL, 
        Media.mediaTitle, 
        Media.mediaDesc, 
        Media.MediaID
    ORDER BY 
        'Likes' DESC;;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-3 grid-item">';
                echo '<img id="imageDisplay" height="576px" width="324px" src="' . $row["URL"] . '" alt="' . '">';
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
                                <input type="hidden" id='likeMedia' name="MediaLikeFK" value="$_SESSION['MediaID']"> 
                                <input type="hidden" id='likeProfile' name="ProfileLikeFK" value="$_SESSION['userid']"> 
                                <button class="like-button" type="submit" name="like_action" value="Like">✓</button>
                                <button class="dislike-button" type="submit" name="like_action" value="dislike">✕</button>
                            </form>
                            
                        </div>
                        <?php
                        echo '<div class="comments">';
                        require("../logic/getComments.inc.php");
                        echo '</div>';
                        echo "<form method='POST' action='../logic/createComment.inc.php' >
                            <input type='hidden' name='MediaID' id='hiddenMediaID' value='MediaID'>
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
    
    <script src="../assets/app.js"></script>

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