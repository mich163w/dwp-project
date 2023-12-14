<?php

require_once("../classes/DBCon.php"); 

session_start();

// Tjekker om brugeren er logget ind som admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== 'admin') {
    // Hvis brugeren ikke er logget ind som admin, omdirigérer til index.php
    header("Location: index.php");
    exit();
}

?>


<!DOCTYPE html>
<html>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/style.css">
<head>
    <title>Edit Page</title>
</head>

<body>
    <div class="logout">
        <a href="../logic/logout.php"> <button class="logout-btn"> Log ud</button></a>
    </div>
    <h1>Hello Admin</h1>

    <!-- Redigeringsknappen vises kun for administratorer -->
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === 'admin') { ?>
        <div class="edit-container">
            <button onclick="document.getElementById('id01').style.display='block'" class="edit-btn">Block user</button>

            <div id="id01" class="edit-modal">
                <div class="edit-modal">
                    <div class="edit-modal-container">
                        <span onclick="document.getElementById('id01').style.display='none'" class="w-button w-display-topright">&times;</span>

                        <?php

                        $query = "SELECT *, isBlocked FROM `Profile`";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class="user-info">
                                <span>
                                    User: <?php echo $row['Username']; ?>
                                    <?php if ($row['isBlocked'] == 1) {
                                        echo "<span class='blocked'>(Blocked)</span>";
                                    } else {
                                        echo "(Not Blocked)";
                                    } ?>
                                </span>
                                <?php if ($row['isBlocked'] == 1) { ?>
                                    <a href='../logic/block.php?Username=<?php echo $row['Username']; ?>&action=unblock'>Unblock</a>
                                <?php } else { ?>
                                    <a href='../logic/block.php?Username=<?php echo $row['Username']; ?>&action=block'>Block</a>
                                <?php } ?>
                            </div>
                        <?php
                        }
                        mysqli_close($conn);
                        ?>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</body>

</html>


