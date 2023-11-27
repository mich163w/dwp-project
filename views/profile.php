<?php
require("../DB/connection.php");
require_once("../classes/SessionHandle.php");
require_once("../classes/DbCon.php");
require_once("../classes/Redirector.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">
    <style>
           body {

background-image: url(../BGimg/DWPBaggrund.jpg);
background-attachment: fixed;
background-size: cover;
height: 1000vh;
font-family: 'Montserrat', sans-serif;
}

.profile {
background: white;
max-width: 600px;
margin: 0 auto;
text-align: center;
padding: 20px;
border-radius: 10px;
text-align: left;
margin-bottom: 10px;
}

form {
text-align: left;
display: flex;
flex-direction: column;
}


input[type="text"],
input[type="password"] {
padding: 10px;
border-radius: 10px;
border: 1px solid #ccc;
margin-bottom: 15px;
width: 96%;
}

input[type="submit"] {
padding: 8px;
border: none;
border-radius: 10px;
background-color:#ddb3b3;
color: white;
cursor: pointer;
width: 16%;
display: flex;
align-self: flex-end;
justify-content: center;
align-items: center;
}

.top {
display: flex;
flex-direction: column;
align-items: center;

}

.profile img {
border-radius: 50%;
margin-bottom: 20px;
object-fit: cover;
}

.profile h2 {
margin-bottom: 10px;
text-align: center;
}

.profile p {
margin-bottom: 5px;
margin-left: 43px;
}

.logout {
display: flex;
justify-content: flex-end;
}

.logout-btn {
background-color: #ddb3b3;
color: #fff;
padding: 10px;
border: none;
border-radius: 10px;
}

.file-avatar {
    position: absolute;
    margin-top: 109px;
    margin-left: -2%;
}

.upload-button {
    width: 53px !important;
    /* margin-left: 4px !important; */
    position: absolute;
    margin: 103px -302px;
    }
    </style>
</head>

<body>
    <div class="logout">
        <a href="logout.php"> <button class="logout-btn"> Log ud</button></a>
    </div>

    <div class="profile">
        <div class="top">
            <?php

            // Tjek om formularen er indsendt for at opdatere avatar
            if (isset($_POST['submit'])) {
                $db = new DbCon();

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
            $db = new DbCon();
            $profileData = $db->dbCon->prepare("SELECT `Avatar` FROM `Profile` WHERE ProfileID = :profileId");
            $profileData->bindParam(':profileId', $_SESSION['userid']);
            $profileData->execute();
            $result = $profileData->fetch();

            $avatarURL = $result['Avatar'] ?? '';

            echo "<form method='post' action='' enctype='multipart/form-data'>";
            echo "<input class='file-avatar' type='file' name='Avatar' accept='image/*'>";
            echo "<input type='submit' name='submit' value='Upload' class='upload-button'>";
            echo "</form>";

            // Vis avatarbilledet
            if (!empty($avatarURL)) {
                echo "<img src='" . $avatarURL . "' alt='Avatar' style='width: 100px; height: 100px;'>";
            } else {
                echo "<img src='./img/802001_man_512x512.png' alt='User Avatar' style='width: 100px; height: 100px;'>";
            }
            ?>

            <input type="hidden" name="ProfileID" value="<?php echo $_SESSION['userid']; ?>">
        </div>

        <form action="updateProfile.php" method="post">
            <?php
            $db = new DbCon();
            $profileData = $db->dbCon->prepare("SELECT * FROM `Profile` WHERE ProfileID = :profileId");
            $profileData->bindParam(':profileId', $_SESSION['userid']);
            $profileData->execute();

            $result = $profileData->fetch();
            ?>

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
