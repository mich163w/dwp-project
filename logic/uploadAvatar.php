<?php
require_once("../DB/connection.php");

if (isset($_POST['submit'])) {
    if (
        in_array($_FILES['Avatar']['type'], ["image/gif", "image/jpeg", "image/jpg", "image/png"]) &&
        $_FILES['Avatar']['size'] < 1000000
    ) {
        if ($_FILES['Avatar']['error'] > 0) {
            echo "Error " . $_FILES['Avatar']['error'];
        } else {
            echo "Upload: " . $_FILES['Avatar']['name'] . "</br>";
            echo "Type: " . $_FILES['Avatar']['type'] . "</br>";
            echo "Size: " . ($_FILES['Avatar']['size'] / 1024) . " kb. </br>";
            echo "Stored: " . $_FILES['Avatar']['tmp_name'];

            $uploadPath = "../img/" . $_FILES['Avatar']['name'];

            if (file_exists($uploadPath)) {
                echo "Can't upload. file already there!!!";
            } else {
                move_uploaded_file($_FILES['Avatar']['tmp_name'], $uploadPath);
                echo "Stored in: " . $uploadPath;

                // Brug den eksisterende databaseforbindelse fra DB/connection.php
                $pic = $uploadPath; // Gem fuld sti i stedet for bare filnavnet
                $sql = "INSERT INTO `Profile` (`Avatar`) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $pic);
                $stmt->execute();
                $stmt->close();
            }
        }
    } else {
        echo "Denne filtype er ikke tilladt, eller filstørrelsen overskrider grænsen på 1 MB.";
    }
}
?>




