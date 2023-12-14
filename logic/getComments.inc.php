<?php
spl_autoload_register(function ($class) {
    include_once "../classes/" . $class . ".php";
});

// Opret en instans af DBCon-klassen
$db = new DBCon();

// Antag, at $mediaCommentFK er din MediaID-værdi (Kun brugt af Ajax)
if (isset($_GET["MediaID"])) {
    $mediaCommentFK = $_GET["MediaID"];

    // Forbered og udfør det forberedte udsagn
    $sql = "SELECT Profile.Username, Profile.Avatar, Comment.CommentText, Comment.dato 
            FROM Media
            JOIN Comment ON Comment.MediaCommentFK = Media.MediaID
            JOIN Profile ON Profile.ProfileID = Comment.ProfileFK
            WHERE Comment.MediaCommentFK = ?";

    // Brug $db->dbCon i stedet for $conn
    $stmt = $db->dbCon->prepare($sql);
    
    // "i" angiver, at det er en integer-værdi
    $stmt->bindParam(1, $mediaCommentFK); // <-- Linje 30
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Håndter resultatet (du kan tilpasse dette baseret på dine behov)
    foreach ($result as $row) {
        echo "<div class='commment-box'>";
        echo "<div class='userBox'>";
        echo "<img id='commentAvatar' src='" . $row['Avatar'] . "' alt='Avatar'><br>";
        echo "<span class='userNameComment'>" . $row['Username'] . "</span><br>";
        echo "</div>";
        echo "<span class='datoComment'>" . $row['dato'] . "</span><br>";
        echo "<span class='msgComment'>" . nl2br($row['CommentText']) . "</span>";
        echo "</div>";
    }
    // ...
}
?>
<link rel="stylesheet" href="../assets/style.css">
