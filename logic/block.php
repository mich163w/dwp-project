<?php
require("../DB/connection.php");

if (isset($_GET['Username'])) {
    $Username = $_GET['Username'];

    // Hent brugerens blokeringsstatus
    $getProfileQuery = "SELECT isBlocked FROM `Profile` WHERE Username = ?";
    $stmtGetProfile = mysqli_prepare($conn, $getProfileQuery);
    mysqli_stmt_bind_param($stmtGetProfile, "s", $Username);

    if (!mysqli_stmt_execute($stmtGetProfile)) {
        die("Error fetching user profile: " . mysqli_stmt_error($stmtGetProfile));
    }

    mysqli_stmt_bind_result($stmtGetProfile, $isBlocked);
    mysqli_stmt_fetch($stmtGetProfile);
    mysqli_stmt_close($stmtGetProfile);

    // Blokeringsstatus
    if ($isBlocked == 1) {
        // Brugeren er blokeret, så unblock den
        $updateProfileQuery = "UPDATE `Profile` SET isBlocked = 0 WHERE Username = ?";
        $stmtProfile = mysqli_prepare($conn, $updateProfileQuery);
        mysqli_stmt_bind_param($stmtProfile, "s", $Username);

        if (!mysqli_stmt_execute($stmtProfile)) {
            die("Error unblocking user: " . mysqli_stmt_error($stmtProfile));
        } else {
            echo "User unblocked successfully";
        } 

        mysqli_stmt_close($stmtProfile);
    } else {
        // Brugeren er ikke blokeret, så bloker den
        $updateProfileQuery = "UPDATE `Profile` SET isBlocked = 1 WHERE Username = ?";
        $stmtProfile = mysqli_prepare($conn, $updateProfileQuery);
        mysqli_stmt_bind_param($stmtProfile, "s", $Username);

        if (!mysqli_stmt_execute($stmtProfile)) {
            die("Error blocking user: " . mysqli_stmt_error($stmtProfile));
        } else {
            echo "User blocked successfully";
        } 

        mysqli_stmt_close($stmtProfile);
    }
} else {
    header("Location: index.php");
}

mysqli_close($conn);
?>
