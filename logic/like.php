<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../classes/DBCon.php");

// Håndter LIKE-anmodningen
// Check if the user is logged in
if (isset($_SESSION['userid'])) { 
    $userid = $_SESSION['userid']; 
    // Check if the form was submitted correctly
    if (isset($_POST['like_action'], $_POST['MediaLikeFK'])) {
        $like_action = ($_POST['like_action'] == 'Like') ? 1 : -1;  
        $MediaID = htmlspecialchars(trim($_POST['MediaLikeFK']));
        // Check if the user has already liked the image
        $stmt_check = $conn->prepare("SELECT * FROM Likes WHERE MediaLikeFK = ? AND ProfileLikeFK = ?");
        $stmt_check->bind_param("ii", $MediaID, $userid);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $stmt_check->close();

        //$output = "UPDATE Likes SET LikeAmount = " . $like_action . " WHERE MediaLikeFK = " . $MediaID . " AND ProfileLikeFK = " . $userid;


        if ($result_check->num_rows > 0) {

            echo "Update:" . $like_action . "/" . $MediaID . "/" . $userid;
            $output = "UPDATE Likes SET LikeAmount = " . $like_action . " WHERE MediaLikeFK = " . $MediaID . " AND ProfileLikeFK = " . $userid;


            // User has already liked the image, perform an UPDATE
            $stmt = $conn->prepare("UPDATE Likes SET LikeAmount = ? WHERE MediaLikeFK = ? AND ProfileLikeFK = ?");
            $stmt->bind_param("iii", $like_action, $MediaID, $userid);
        } else {
            // User has not liked the image, perform an INSERT
            echo "Insert:" . $like_action . "/" . $MediaID . "/" . $userid;

            $stmt = $conn->prepare("INSERT INTO Likes (LikeAmount, MediaLikeFK, ProfileLikeFK) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $like_action, $MediaID, $userid);
        }
        if (!$stmt) {
            die("Forberedelse mislykkedes: " . $conn->error);
        }

        //echo $output;

        
        if (!$stmt->execute()) {
            die("Fejl ved udførelse af forespørgsel: " . $stmt->error);
        } else {
            echo "Handling udført!";
        }
        
        $stmt->close();
    } else {
        die("Formularen blev ikke sendt korrekt.");
    }
} else {
    echo "Du skal være logget ind for at kunne like billeder.";
}
// Close database connection
$conn->close();
