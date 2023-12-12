<?php
require_once("constants.php");
class DBCon
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
    
    public function getLastModified($profileId) {
        $stmt = $this->dbCon->prepare("SELECT last_modified FROM `Profile` WHERE ProfileID = :profileId");
        $stmt->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $stmt->execute();
        $lastModified = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $lastModified;
    }
    
    public function updateLastModified($profileId, $lastModified) {
        $stmt = $this->dbCon->prepare("UPDATE `Profile` SET last_modified = :lastModified WHERE ProfileID = :profileId");
        $stmt->bindParam(':lastModified', $lastModified, PDO::PARAM_STR);
        $stmt->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    public function updateProfile($profileId, $Fname, $Lname, $Email, $Pass, $Avatar, $Birthdate) {
        $stmt = $this->dbCon->prepare("UPDATE `Profile` SET Fname = :Fname, Lname = :Lname, Email = :Email, Pass = :Pass, Avatar = :Avatar, Birthdate = :Birthdate, last_modified = CURRENT_TIMESTAMP WHERE ProfileID = :profileId");
        $stmt->bindParam(':Fname', $Fname, PDO::PARAM_STR);
        $stmt->bindParam(':Lname', $Lname, PDO::PARAM_STR);
        $stmt->bindParam(':Email', $Email, PDO::PARAM_STR);
        $stmt->bindParam(':Pass', $Pass, PDO::PARAM_STR);
        $stmt->bindParam(':Avatar', $Avatar, PDO::PARAM_STR);
        $stmt->bindParam(':Birthdate', $Birthdate, PDO::PARAM_STR);
        $stmt->bindParam(':profileId', $profileId, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    public function getProfileIdByUsername($username) {
        $stmt = $this->dbCon->prepare("SELECT ProfileID FROM Profile WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchColumn();
    } 
    public function updateLastLogin($profileId) {
        $stmt = $this->dbCon->prepare("UPDATE `Profile` SET last_login = CURRENT_TIMESTAMP WHERE ProfileID = :profileId");
        $stmt->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $stmt->execute();
    } 
    public function getLastLogin($profileId) {
        $stmt = $this->dbCon->prepare("SELECT last_login FROM `Profile` WHERE ProfileID = :profileId");
        $stmt->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $stmt->execute();
        $lastLogin = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $lastLogin;
    }
    
}
?>
<?php
require_once("DBCon.php");

$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS);
if(!$conn) {
    die("Error!");
}
$conn->select_db(DB_NAME);

$dbSelect = mysqli_select_db($conn, DB_NAME);

if (!$dbSelect) {
    die("Error: Unable to select database. " . mysqli_error($conn));
}
?>

