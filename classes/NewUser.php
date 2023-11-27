<?php
class NewUser
{
    public $message;
    public function __construct($Fname, $Lname, $Email, $Username, $Pass)
    {
        // perform validations on the form data
        $db = new DbCon();
        $Fname = trim($_POST['Fname']);
        $Lname = trim($_POST['Lname']);
        $Email = trim($_POST['Email']);
        $Username = trim($_POST['Username']);
        $Pass = trim($_POST['Pass']);
        $iterations = ['cost' => 15];
        $hashed_password = password_hash($Pass, PASSWORD_BCRYPT, $iterations);
        $profile = $db->dbCon->prepare("INSERT INTO `Profile` (Fname, Lname, Email, Username, Pass) VALUES ('{$Fname}', '{$Lname}','{$Email}', '{$Username}', '{$hashed_password}')");

        if ($profile->execute()) {
            $this->message = "User Created.";
            header("Location: login.php");
            exit;
        } else {
            $this->message = "User could not be created.";
        }

        $db->DBClose();
    }
}
