<?php require("../DB/connection.php"); ?>

<body>
    <div>
        
    </div>
    <h1>SipCheer<img src="./img/logo-sip.png" alt="" style="height: 57px; width: 57px; margin-left: 5px;"></h1>
    <h2>Share your drinks with friends</h2>
    <div class="btns">
        <a href="./login.php"> <button class="login">Login</button></a>
        <a href="./newuser.php"> <button class="signup">Sign up</button></a>
        <a class="rules" href="./rules.php">Rules</a>
    </div>
    
</body>
<title>Frontpage</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">

<style>
    body {
        background-image: url(./img/sip.png);
        background-attachment: fixed;
        background-size: cover;
        color: white;
        font-family: 'Montserrat', sans-serif;
        margin-top: 15%;
    }

    h1 {
        font-size: 75px;
        margin: 0 150px;
    }

    h2 {
        font-size: 30px;
        margin: 0 150px;
        font-weight: lighter;
    }


    .btns {
        margin-top: 18px;
        margin-left: 150px;
    }

    .login {
        width: 12%;
        background-color: #ddb3b3;
        color: black;
        padding: 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 11px;
        margin: 5px;
    }

    .signup {
        width: 12%;
        background-color: white;
        color: black;
        padding: 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 11px;
        margin: 5px;
    }

    .rules {
    text-decoration: none;
    color: white;
    }

    .rules:hover {
    text-decoration: underline;
    }

</style>