<?php
spl_autoload_register(function ($class) {
    include_once "../classes/" . $class . ".php";
});
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="../assets/style.css">
<head>
    <title>Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">

</head>

<body>
    <div class="logout">
        <a href="../logic/logout.php"> <button class="logout-btn"> Log ud</button></a>
    </div>

    <div class="profile">
        <div class="top">
            <?php

            // Tjek om formularen er indsendt for at opdatere avatar
            if (isset($_POST['submit'])) {
                $db = new DBCon();

                $avatarPath = "../img/" . $_FILES['Avatar']['name'];

                if (move_uploaded_file($_FILES['Avatar']['tmp_name'], $avatarPath)) {
                    if (isset($_SESSION['userid'])) {
                        $db->updateAvatar($_SESSION['userid'], $avatarPath);
                    } else {
                        echo "Fejl ved upload af avatarbillede: Bruger-ID ikke sat.";
                    }
                } else {
                    echo "Fejl ved upload af avatarbillede.";
                }

            }
            
            // Hent avatar fra databasen
            $db = new DBCon();
            $profileData = $db->dbCon->prepare("SELECT *, DATE_FORMAT(last_modified, '%Y-%m-%d %H:%i:%s') AS formatted_last_modified FROM `Profile` WHERE ProfileID = :profileId");
            $profileData->bindParam(':profileId', $_SESSION['userid']);
            $profileData->execute();
            $result = $profileData->fetch();

            $avatarURL = $result['Avatar'] ?? '';
            $lastModified = $result['formatted_last_modified'] ?? '';

            echo "<form method='post' action='' enctype='multipart/form-data'>";
            echo "<input class='file-avatar' type='file' name='Avatar' accept='image/*'>";
            echo "<input type='submit' name='submit' value='Upload' class='upload-button'>";
            echo "</form>";

            // Vis avatarbilledet
            if (!empty($avatarURL)) {
                echo "<img src='" . $avatarURL . "' alt='Avatar' style='width: 100px; height: 100px;'>";
            } else {
                echo "<img src='../img/802001_man_512x512.png' alt='User Avatar' style='width: 100px; height: 100px;'>";
            }
            $profileId = $_SESSION['userid'];
            $db = new DbCon();
            $lastLogin = $db->getLastLogin($profileId);
            echo "<p>Last Login: " . $lastLogin . "</p>";
            ?>

            <p>Last Modified: <?php echo $lastModified; ?></p>
            <input type="hidden" name="ProfileID" value="<?php echo $_SESSION['userid']; ?>">
        </div>


        <?php
            $db = new DBCon();
            $profileData = $db->dbCon->prepare("SELECT * FROM `Profile` WHERE ProfileID = :profileId");
            $profileData->bindParam(':profileId', $_SESSION['userid']);
            $profileData->execute();

            $result = $profileData->fetch();
            ?>


        <form action="../logic/updateProfile.php" method="post">
            <h2>@<?php echo $result['Username']; ?></h2>
            <input type="hidden" name="ProfileID" value="<?php echo $result['ProfileID']; ?>">
            First name: <input type="text" name="Fname" value="<?php echo $result['Fname']; ?>">
            Last name: <input type="text" name="Lname" value="<?php echo $result['Lname']; ?>">
            Username: <input type="text" name="Username" value="<?php echo $result['Username']; ?>">
            Email: <input type="text" name="Email" value="<?php echo $result['Email']; ?>">
            Password: <input type="password" name="Pass" value="<?php echo $result['Pass']; ?>">
            <input type="submit" name="submit" value="Save">
        </form>

    </div>

</body>

</html>