<?php
// Inkluder databaseforbindelse
require_once("../classes/DBCon.php");
// Antag, at $mediaCommentFK er din MediaID-værdi (Kun brugt af Ajax)
if (isset($_GET["MediaID"])) {

    $mediaCommentFK = $_GET["MediaID"];



    // Forbered og udfør det forberedte udsagn
    $sql = "SELECT Profile.Username, Profile.Avatar, Comment.CommentText, Comment.dato 
            FROM Media
            JOIN Comment ON Comment.MediaCommentFK = Media.MediaID
            JOIN Profile ON Profile.ProfileID = Comment.ProfileFK
            WHERE Comment.MediaCommentFK = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mediaCommentFK); // "i" angiver, at det er en integer-værdi
    $stmt->execute();
    $result = $stmt->get_result();

    // Håndter resultatet (du kan tilpasse dette baseret på dine behov)
    while ($row = $result->fetch_assoc()) {
        echo "<div class='commment-box'>";
        echo "<div class='userBox'";
        echo "<img id='commentAvatar' src='" . $row['Avatar'] . "' alt='Avatar'><br>";
        echo "<span class='userNameComment'>" . $row['Username'] . "</span><br>";
        echo "</div>";
        echo "<span class='datoComment'>" . $row['dato'] . "</span><br>";
        echo "<span class='msgComment'>" . nl2br($row['CommentText']);
        "</span>";
        echo "</div>";
    }
}

?>

<style>
    .commment-box {
        border: 1px solid gray;
        width: 95%;
        height: auto;
        padding: 2%;
        margin-bottom: 1%;
        border-radius: 20px;
    }

    ​ .userBox {
        display: flex;
        align-items: center;
        gap: 2%;
    }

    #commentAvatar {
        height: 40px;
        width: 40px;
        background-color: red;
        border-radius: 980px;
    }

    .userNameComment {
        color: grey;
        opacity: 0.9;
        margin-left: 5%;
    }

    .datoComment {
        color: grey;
        opacity: 0.9;
        font-size: 12px;
    }

    .msgComment {
        color: black;
    }
</style>