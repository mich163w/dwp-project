
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
</head>

<?php
if (!empty($msg)) {
    echo "<p>" . $msg . "</p>";
}
?>

<form action="" method="post">
<h2>Sign up</h2>
  <h4>First name:</h4>  
    <input type="text" name="Fname" maxlength="30" />
   <h4>Last name:</h4> 
    <input type="text" name="Lname" maxlength="30" />
    <h4>Username:</h4>  
    <input type="text" name="Username" maxlength="30" />
    <h4>Email:</h4> 
    <input type="text" name="Email" maxlength="30" />
    
   <h4>Password:</h4> 
    <input type="password" name="Pass" maxlength="30" />
    <a href="./login.php"><p>Already a user? Login</p></a>
    <input type="submit" name="submit" value="Sign up" />
  
</form>
</body>

</html>

<link rel="preconnect" href="https://fonts.googleapis.com"> 
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">

<style>
    body {
        font-family: Arial, sans-serif;
        /* background-color: #f5f5f5; */
        margin: 0;
        padding: 0;
        background-image: url(../BGimg/DWPBaggrund.jpg);
        background-size: cover;
    }

    p {
        font-size: 11;
    }

    h2 {
        text-align: center;
        font-family: 'Montserrat', sans-serif;
    }
h4 {
    font-family: 'Montserrat', sans-serif;
    font-weight: lighter;
    margin: auto;
}
    form {
        max-width: 400px;
        margin: 150px auto;
        background-color: #ffffff;
        padding: 27px;

        border-radius: 10px;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }


    label {
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    input[type="submit"] {
        width: 100%;
        background-color: #ddb3b3;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 11px;
        font-family: 'Montserrat', sans-serif;
    }

    input[type="submit"]:hover {
        background-color: #e6cdcd;
    }
</style>