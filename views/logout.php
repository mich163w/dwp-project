<?php
//require_once("../DB/DBcon.php");
// Start sessionen
session_start();

// Sørg for at tømme alle sessionens variabler
$_SESSION = array();

// Hvis sessionen er aktiv, ødelæg den
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Omdirigér til login-siden eller en anden ønsket destination efter logout
header("Location: login.php"); 
exit;
?>