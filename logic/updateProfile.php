<?php
require_once("../DB/DBcon.php");

if (isset($_POST['submit'])) {
    $ProfileID = $_POST['ProfileID'];
    $Fname = htmlspecialchars(trim($_POST['Fname']));
    $Lname = htmlspecialchars(trim($_POST['Lname']));
    $Username = htmlspecialchars(trim($_POST['Username']));
    $Email = htmlspecialchars(trim($_POST['Email']));
    $Pass = htmlspecialchars(trim($_POST['Pass']));

    $db = new DBCon();

    // Hent brugerens nuværende sidste opdateret tidspunkt
    $lastModified = $db->getLastModified($ProfileID);

    // Opdater brugerprofil
    $update_query = "UPDATE Profile SET Username=?, Fname=?, Lname=?, Email=?, Pass=?, last_modified=CURRENT_TIMESTAMP WHERE ProfileID=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sssssi", $Username, $Fname, $Lname, $Email, $Pass, $ProfileID);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt); // Luk det forberedte udsagn

        // Opdater last_modified til det nye tidspunkt
        $db->updateLastModified($ProfileID, $lastModified);

        mysqli_close($conn); // Luk forbindelsen til databasen
        header("location: profile.php"); // Omdiriger til profile.php efter opdatering
        exit;
    } else {
        echo "Fejl ved opdatering: " . mysqli_error($conn); // Vis fejlmeddelelse ved opdateringsfejl
    }
}
?>






