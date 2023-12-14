<?php
session_start();

require("../classes/DBCon.php");

// Tjek om der er filer, der er sendt via POST
if (!empty($_FILES['picture']['name'])) {
    // Definér målmappen, hvor filen skal flyttes til
    $targetDirectory = "../img/";  // Juster stien baseret på dit behov

    // Opret et unikt filnavn baseret på den oprindelige fil
    $originalFileName = $_FILES['picture']['name'];
    $uniqueFileName = time() . '_' . $originalFileName;

    // Fuld sti til den uploadede fil
    $targetFilePath = $targetDirectory . $uniqueFileName;

    // Flyt den uploadede fil til målmappen
    if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetFilePath)) {
        // Hent uploadede filoplysninger
        $URL = $targetFilePath;
        $mediaTitle = htmlspecialchars(trim($_POST['mediaTitle']));
        $mediaDesc = htmlspecialchars(trim($_POST['mediaDesc']));

        // Tjek om brugeren er logget ind
        if (isset($_SESSION['userid'])) {
            $mediaProfileFK = $_SESSION['userid'];

            // Forbered SQL-udtryk og bind parametre
            $stmt1 = $conn->prepare("INSERT INTO Media (URL, mediaTitle, mediaDesc, mediaProfileFK) VALUES (?, ?, ?, ?)");
            $stmt1->bind_param("sssi", $URL, $mediaTitle, $mediaDesc, $mediaProfileFK);

            // Udfør SQL-forespørgsel
            $stmt1->execute();

            // Tjek for fejl under udførelse
            if ($stmt1->errno) {
                echo "Fejl ved indsættelse i databasen: " . $stmt1->error;
            } else {
                echo "Data blev indsat i databasen.";
            }

            // Luk SQL-udtrykket
            $stmt1->close();
        } else {
            echo "Fejl: Bruger ikke logget ind.";
        }
    } else {
        echo "Fejl ved flytning af fil til destinationen.";
    }
} else {
    echo "Fejl: Ingen fil blev valgt.";
}

// Luk forbindelsen til databasen
$conn->close();
?>