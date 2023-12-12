<?php

require("../classes/DBCon.php");

    if (isset($_POST['commentSubmit'])) {
        $CommentText = htmlspecialchars(trim($_POST['CommentText']));
        $dato = htmlspecialchars(trim($_POST['dato']));
        $MediaCommentFK = $_POST['MediaID'];
        $ProfileFK = 1; // Dette er til test, det skal ændres til brugeren som er logget ind

        if($conn){

            $stmt = $conn->prepare("INSERT INTO Comment (CommentText, dato, MediaCommentFK, ProfileFK) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $CommentText, $dato, $MediaCommentFK, $ProfileFK);
            
            $stmt->execute();
            $stmt->close();
            $conn->close();
            
            //header( "Location: ./index.php" );

        } else {
            die("error");
        }
    } 