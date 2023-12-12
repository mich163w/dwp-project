<?php
require("../classes/DBCon.php");

// Håndter LIKE-anmodningen
// Check if the user is logged in
if (isset($_SESSION['user_id'])) { //Måske ændres til ProfileID
    $user_id = $_SESSION['user_id']; //Måske ændres til ProfileID
    // Check if the form was submitted correctly
    if (isset($_POST['like_action'], $_POST['MediaLikeFK'])) {
        $like_action = ($_POST['like_action'] == 'Like') ? 1 : -1;
        $media_id = htmlspecialchars(trim($_POST['MediaLikeFK']));
        // Check if the user has already liked the image
        $stmt_check = $conn->prepare("SELECT * FROM Likes WHERE MediaLikeFK = ? AND ProfileLikeFK = ?");
        $stmt_check->bind_param("ii", $media_id, $user_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $stmt_check->close();
        if ($result_check->num_rows > 0) {
            // User has already liked the image, perform an UPDATE
            $stmt = $conn->prepare("UPDATE Likes SET LikeAmount = ? WHERE MediaLikeFK = ? AND ProfileLikeFK = ?");
            $stmt->bind_param("iii", $like_action, $media_id, $user_id);
        } else {
            // User has not liked the image, perform an INSERT
            $stmt = $conn->prepare("INSERT INTO Likes (LikeAmount, MediaLikeFK, ProfileLikeFK) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $like_action, $media_id, $user_id);
        }
        if (!$stmt) {
            die("Forberedelse mislykkedes: " . $conn->error);
        }
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
/*
HasLiked fra index ind i like.php
Lav INsert om til update, og hvis ikke allerede eksistere så insert
*/