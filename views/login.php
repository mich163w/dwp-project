<html>
<title>Login</title>

<head>
    <meta http-equiv="Content-Type" content="text/html" />
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">

</head>

<body>
    <?php
    spl_autoload_register(function ($class) {
        include_once "../classes/" . $class . ".php";
    });
    require_once("../logic/login.php"); ?>


    <?php
    if (!empty($msg)) {
        echo "<p>" . $msg . "</p>";
    }
    ?>


    <form id="loginForm" action="" method="post">

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