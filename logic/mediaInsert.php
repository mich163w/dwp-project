<?php

require_once("upload.php");

echo $_FILES['picture']['name'];


require("../DB/DBcon.php");
session_start();

$stmt1 = $conn->prepare("INSERT INTO Media (URL, mediaTitle, mediaDesc, mediaProfileFK) VALUES (?, ?, ?, ?)");
$stmt1->bind_param("sssi", $URL, $mediaTitle, $mediaDesc, $mediaProfileFK);

    $URL = htmlspecialchars(trim($URL));
    $mediaTitle = htmlspecialchars(trim($_POST['mediaTitle']));
    $mediaDesc = htmlspecialchars(trim($_POST['mediaDesc']));
    $mediaProfileFK = $_SESSION['userid'];

    $stmt1->execute();

$stmt1->close();
$conn->close();

