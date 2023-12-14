<?php spl_autoload_register(function ($class) {
    include_once "../classes/" . $class . ".php";
});?>
<?php

// START FORM PROCESSING
if (isset($_POST['submit'])) { // Form has been submitted.
    $profile = new NewUser($_POST['Fname'], $_POST['Lname'],$_POST['Username'], $_POST['Email'],$_POST['Pass']);
    $msg = $profile->message;
}
?>
<html>
<title>Sign up</title>

<head>
    <meta http-equiv="Content-Type" content="text/html" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<?php
if (!empty($msg)) {
    echo "<p>" . $msg . "</p>";
}
?>

<form class="newuser" action="" method="post">
<h2>Sign up</h2>
  <h4>First name:</h4>  
    <input class="newuser-input" type="text" name="Fname" maxlength="30" />
   <h4>Last name:</h4> 
    <input class="newuser-input" type="text" name="Lname" maxlength="30" />
    <h4>Username:</h4>  
    <input class="newuser-input" type="text" name="Username" maxlength="30" />
    <h4>Email:</h4> 
    <input class="newuser-input" type="text" name="Email" maxlength="30" />
   <h4>Password:</h4> 
    <input class="newuser-input" type="password" name="Pass" maxlength="30" />
    <a href="login.php"><p>Already a user? Login</p></a>
    <input class="newuser-submit" type="submit" name="submit" value="Sign up" />
  
</form>
</body>

</html>

