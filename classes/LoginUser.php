<?php


class LoginUser
{
    public $message;

    public function __construct($Username, $Pass)
    {
        // Starter sessionen, hvis den ikke allerede er startet
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $db = new DBCon();
        $Username = trim($Username);
        $Pass = trim($Pass);
        $profile = $db->dbCon->prepare("SELECT ProfileID, Username, Pass, IsAdmin FROM `Profile` WHERE Username = :username LIMIT 1");
        $profile->bindParam(':username', $Username);
        $profile->execute();

        $found_user = $profile->fetchAll();
        if (count($found_user) == 1) {
            if (password_verify($Pass, $found_user[0]['Pass'])) {
                if ($found_user[0]['IsAdmin'] == 1) {
                    // Administrator login
                    $_SESSION['admin'] = $found_user[0]['Username'];
                    $_SESSION['Profile'] = $found_user[0]['Username'];
                    $_SESSION['userid'] = $found_user[0]['ProfileID'];
                    $redirect = new Redirector("../views/edit.php");
                } else {
                    // Almindelig bruger login
                    $_SESSION['Profile'] = $found_user[0]['Username'];
                    $_SESSION['userid'] = $found_user[0]['ProfileID'];
                    $redirect = new Redirector("../views/index.php");
                }
            } else {
                $this->message = "Brugernavn eller adgangskode er forkert.<br />Sørg for, at din Caps Lock-tast er slået fra, og prøv igen.";
            }
        } else {
            $this->message = "Ingen bruger fundet.<br />Sørg for, at din Caps Lock-tast er slået fra, og prøv igen.";
        }
    }
}
?>
