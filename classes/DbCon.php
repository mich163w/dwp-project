<?php
class DbCon
{
    private $Username = "root";
    private $Pass = "";
    public $dbCon;
    public function __construct(){
        $dsn = 'mysql:host=localhost;dbname=SipCheer;charset=utf8';
        $this->dbCon = new PDO($dsn, $this->Username, $this->Pass);
        $this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function DBClose(){
        $this->dbCon = null;
    }

    public function getUserInfo($username) {
        $stmt = $this->dbCon->prepare("SELECT ProfileID, IsAdmin FROM Profile WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function updateAvatar($userId, $avatarPath) {
        $stmt = $this->dbCon->prepare("UPDATE `Profile` SET `Avatar` = :avatarPath WHERE ProfileID = :userId");
        $stmt->bindParam(':avatarPath', $avatarPath);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }
}
?>
