<?php
class SessionHandle
{
    public function __construct()
    {
        session_start();// Start the session
    }

    public function logged_in()
    {
        return isset($_SESSION['ProfileID']) || isset($_SESSION['userid']);
    }

    public function confirm_logged_in()
    {
        if (!$this->logged_in()) {
            $redirect = new Redirector("../views/login.php");
        }
    }

    public function destroy()
    {
        session_unset();
        session_destroy();
    }
}
?>