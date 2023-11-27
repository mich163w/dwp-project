<?php
require("../DB/connection.php");

if (isset($_GET['Username'])) {
    $Username = $_GET['Username'];

    // Opdater brugerens blokeringsstatus
    $updateProfileQuery = "UPDATE `Profile` SET IsBlocked = 1 WHERE Username = ?";
    $stmtProfile = mysqli_prepare($conn, $updateProfileQuery);
    mysqli_stmt_bind_param($stmtProfile, "s", $Username);

    if (!mysqli_stmt_execute($stmtProfile)) {
        die("Error blocking user: " . mysqli_stmt_error($stmtProfile));
    } else {
        echo "User blocked successfully";
    } 
    mysqli_stmt_close($stmtProfile);
} else {
    header("Location: index.php");
}

mysqli_close($conn);
?>


