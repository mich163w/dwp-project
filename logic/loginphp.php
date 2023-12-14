<?php
spl_autoload_register(function ($class) {
    include_once "../classes/" . $class . ".php";
});

$session = new SessionHandle();
// Check if the user is already logged in
if ($session->logged_in()) {
    $redirect = new Redirector("./index.php");
}

// Process form submission
if (isset($_POST['submit'])) {
    $profile = new LoginUser($_POST['Username'], $_POST['Pass']);
    $msg = $profile->message;

    // Log ind som administrator
    $Username = $_POST['Username'];
    $Pass = $_POST['Pass'];
    
    // Brug en mere sikker måde at gemme adgangsoplysninger
    $adminCredentials = ['admin' => 'adminpass'];

    if (array_key_exists($Username, $adminCredentials) && password_verify($Pass, password_hash($adminCredentials[$Username], PASSWORD_DEFAULT))) {
        // Hent profilens ID baseret på brugernavnet
        $db = new DbCon();
        $profileId = $db->getProfileIdByUsername($Username);

        // Opdater sidste login i databasen
        $db->updateLastLogin($profileId);

        $session->logged_in($Username); // Log ind som administrator
        $_SESSION['admin'] = $Username; // Gem admin-session
        $redirect = new Redirector("../views/edit.php"); // Omdirigér til admin-siden
    } else {
        // Display an error message
        echo "<p>" . $msg . "</p>";
    }
}
?>