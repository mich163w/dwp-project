<?php
class LoginUser
{
    public $message;

    public function __construct($Username, $Pass)
    {
        // Kommentar: Start sessionen, hvis den ikke allerede er startet
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $db = new DbCon();
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
                    $redirect = new Redirector("edit.php");
                } else {
                    // Almindelig bruger login
                    $_SESSION['Profile'] = $found_user[0]['Username'];
                    $_SESSION['userid'] = $found_user[0]['ProfileID'];
                    $redirect = new Redirector("index.php");
                }
            } else {
                $this->message = "Brugernavn/adgangskombinationen er forkert.<br />Sørg for, at din Caps Lock-tast er slået fra, og prøv igen.";
            }
        } else {
            $this->message = "Ingen sådan bruger i databasen.<br />Sørg for, at din Caps Lock-tast er slået fra, og prøv igen.";
        }
    }
}
?>


