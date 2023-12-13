<?php

spl_autoload_register(function ($class) {
    include_once "../classes/" . $class . ".php";
}); 
$session = new SessionHandle();

// Check if the user is already logged in
if ($session->logged_in()) {
    $redirect = new Redirector("../views/index.php");
}

// Process form submission
if (isset($_POST['submit'])) {
    $profile = new LoginUser($_POST['Username'], $_POST['Pass']);
    $msg = $profile->message;

    // Log ind som administrator
    $Username = $_POST['Username'];
    $Pass = $_POST['Pass'];
    if ($Username === 'admin' && $Pass === 'adminpass') {
        // Hent profilens ID baseret på brugernavnet
        $db = new DbCon();
        $profileId = $db->getProfileIdByUsername($Username);

        // Opdater sidste login i databasen
        $db->updateLastLogin($profileId);

        $session->logged_in($Username); // Log ind som administrator
        $_SESSION['admin'] = $Username; // Gem admin-session
        $redirect = new Redirector("../views/edit.php"); // Omdirigér til admin-siden

        // Check if the login attempt was successful
        if ($session->logged_in()) {
            $redirect = new Redirector("../views/index.php");
        } else {
            // Display an error message
            echo "<p>" . $msg . "</p>";
        }
    }
}
?>
