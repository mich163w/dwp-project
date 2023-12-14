<?php
require_once("../classes/DBCon.php");
session_start();

if (isset($_POST['commentSubmit'])) {
    // Filtrer og validér input
    $CommentText = htmlspecialchars(trim($_POST['CommentText']));
    $dato = htmlspecialchars(trim($_POST['dato']));
    $MediaCommentFK = intval($_POST['MediaID']); // Sørg for, at det er en gyldig integer
    $ProfileFK = isset($_SESSION['userid']) ? intval($_SESSION['userid']) : 0; // Sørg for, at det er en gyldig integer

    if ($ProfileFK > 0 && $conn) {
        $stmt = $conn->prepare("INSERT INTO Comment (CommentText, dato, MediaCommentFK, ProfileFK) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $CommentText, $dato, $MediaCommentFK, $ProfileFK);
        
        $stmt->execute();
        $stmt->close();
        $conn->close();
        
        header( "Location: ../index.php" );
        exit();
    } else {
        die("Error: Invalid user or database connection");
    }
}
?>