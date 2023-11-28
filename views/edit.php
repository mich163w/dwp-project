<?php require("../DB/connection.php"); ?>
<?php require_once("../classes/SessionHandle.php"); ?>
<?php require_once("../classes/DbCon.php"); ?>
<?php require_once("../classes/Redirector.php"); ?>


<?php
session_start();

// ... (andre krævede inkluder)
// Tjek om brugeren er logget ind som admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== 'admin') {
    // Hvis brugeren ikke er logget ind som admin, omdirigér til en anden side
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Page</title>
</head>

<body>
    <div class="logout">
        <a href="logout.php"> <button class="logout-btn"> Log ud</button></a>
    </div>
    <h2>Hello Admin</h2>
    <p>You can edit stuff here</p>

    <!-- Redigeringsknappen vises kun for administratorer -->
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === 'admin') { ?>
        <div class="edit-container">
            <button onclick="document.getElementById('id01').style.display='block'" class="edit-btn">Block user</button>

            <div id="id01" class="w-modal">
                <div class="w-modal-content">
                    <div class="w-container">
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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">


<style>
    body {
        font-family: 'Montserrat', sans-serif;
        padding: 0;
        background-image: url(../BGimg/DWPBaggrund.jpg);
        background-size: cover;
    }

    .logout {
        display: flex;
        justify-content: flex-end;
        padding: 10px;
    }

    .logout-btn {
        background-color: #ddb3b3;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    .edit-container {
        display: flex;
        flex-direction: column;

    }

    .edit-btn {
        width: 20%;
        background-color: #ddb3b3;
        color: #fff;
        padding: 15px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 20px;
    }

    .user-info {
        margin-top: 20px;
        background-color: #f0f0f0;
        padding: 15px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 30%;
    }

    .blocked {
        color: red;
        font-weight: bold;
    }
</style>