<?php

require_once("upload.php");

echo "Hello World";
echo $_FILES['picture']['name'];


require("../DB/connection.php");
// prepare and bind
$stmt = $conn->prepare("INSERT INTO Profile (ProfileID, Username, Fname, Lname, Email, Pass, Avatar, Birthdate, isAdmin, isBlocked) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssssii", $ProfileID, $Username, $Fname, $Lname, $Email, $Pass, $Avatar, $Birthdate,$isAdmin, $isBlocked);


// set parameters and execute
$ProfileID = htmlspecialchars(trim($_POST['ProfileID']));
$Username = htmlspecialchars(trim($_POST['user'])); //XSS, SQL injections
$Fname = htmlspecialchars(trim($_POST['Fname']));
$Lname = htmlspecialchars(trim($_POST['Lname']));
$Email = htmlspecialchars(trim($_POST['Email']));
$Pass = htmlspecialchars(trim($_POST['Pass']));
$Avatar = htmlspecialchars(trim($_POST['Avatar']));
$Birthdate = htmlspecialchars(trim($_POST['Birthdate']));
$isAdmin = isset($_POST['isAdmin']) ? 1 : 0;
// Standardværdi for IsBlocked, da en ny bruger normalt ikke er blokeret
$IsBlocked = 0;
$stmt->execute();


$stmt1 = $conn->prepare("INSERT INTO Media (URL, mediaTitle, mediaDesc, mediaComment, mediaLike) VALUES (?, ?, ?, ?, ?)");
$stmt1->bind_param("ssssi", $URL, $mediaTitle, $mediaDesc, $mediaComment, $mediaLike);

$URL = htmlspecialchars(trim($_POST['URL']));
$mediaTitle = htmlspecialchars(trim($_POST['Title']));
$mediaDesc = htmlspecialchars(trim($_POST['Desc']));
$mediaComment = htmlspecialchars(trim($_POST['mediaComment']));
$mediaLike = htmlspecialchars(trim($_POST['mediaLike']));
$stmt1->execute();

$stmt2 = $conn->prepare("INSERT INTO Comment (CommentID, CommentText, LikeCount) VALUES (?, ?, ?)");
$stmt2->bind_param("si", $CommentID, $CommentText, $LikeCount);

$CommentText = htmlspecialchars(trim($_POST['CommentText']));
$LikeCount = htmlspecialchars(trim($_POST['CommentLike']));
$stmt2->execute();

$stmt = $conn->prepare("INSERT INTO Likes (LikeAmount) VALUES (?)");
$stmt->bind_param("i", $LikeAmount);

$LikeAmount = htmlspecialchars(trim($_POST['Likes']));
$stmt->execute();

$stmt->close();
$conn->close();





$profile = "INSERT INTO `Profile` (`ProfileID`, `Username`, `Fname`, `Lname`, `Email`, `Pass`, `Avatar`, `Birthdate`) VALUES ('$ProfileID', '$Username', '$Fname', '$Lname', '$Email', '$Pass', '$Avatar, '$Birthdate');";
$media = "INSERT INTO `Media` (`URL`, `mediaTitle`, `mediaDesc`, `mediaComment`, `mediaLike`) VALUES ('$URL', '$mediaTitle', '$mediaDesc', '$mediaComment', '$mediaLike');";
$comment = "INSERT INTO `Comment` (`CommentID`, `CommentText`, `LikeCount`) VALUES ('$CommentID', '$CommentText', '$LikeCount');";
$likes = "INSERT INTO `Likess` (`LikeID`, `LikeAmount`) VALUES ('$LikeID', '$LikeAmount');";



if (!mysqli_query($conn, $profile, $post, $media, $comment, $likes)) {
    die("Could not add: " . mysqli_error($conn));
} else {
    header("Location: index.php");
}
