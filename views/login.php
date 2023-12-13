<html>
<title>Login</title>

<head>
    <meta http-equiv="Content-Type" content="text/html" />
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">


</head>

<body>
<?php
spl_autoload_register(function ($class) {
    include_once "../classes/" . $class . ".php";
});?>
    <?php
    if (!empty($msg)) {
        echo "<p>" . $msg . "</p>";
    }
    ?>
 <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
    <form id="loginForm" action="../logic/login.php" method="post" >

        <h2>Login</h2>
        <h4>Username:</h4>
        <input type="text" name="Username" maxlength="30" />
        <h4>Password:</h4>
        <input type="password" name="Pass" maxlength="30" />
        <a href="newuser.php">
            <p>Or sign up</p>
        </a>
      
        <input type="submit" name="submit" value="Login" />
    </form>
</body>

</html>




<style>
    body {
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        padding: 0;
        background-image: url(../BGimg/DWPBaggrund.jpg);
        background-size: cover;
    }

    h2 {
        text-align: center;
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

    p {
        font-size: 12px;
        color: #9b9b9b;
        margin-top: -4px;
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
    }

    input[type="submit"]:hover {
        background-color: #e6cdcd;
    }
</style>