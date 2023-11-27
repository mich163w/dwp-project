<?php 
if(isset($_POST['submit'])) {
    if((($_FILES['picture']['type']=="image/gif") || 
        ($_FILES['picture']['type']=="image/png") || 
        ($_FILES['picture']['type']=="image/jpeg") ||
        ($_FILES['picture']['type']=="image/jpg")) &&(
    ($_FILES['picture']['size']<1000000) // Størrelsen skal være mindre end 1 Megabyte
    ))


    if($_FILES['picture']['error']>0) {
        echo "ERROR ". $_FILES['picture']['error'];
    } else {
        echo "Upload: ". $_FILES['picture']['name']."</br>";
        
        if(file_exists("../img/".$_FILES['picture']['name'])) {
            echo "Can't upload. File already there!";
        } else {
            move_uploaded_file($_FILES['picture']['tmp_name'],
            "../img/".$_FILES['picture']['name']);
            echo "Stored in: ../img/".$_FILES['picture']['name'];
            
            $URL = "../img/".$_FILES['picture']['name'];
            
        
        }
    }    
}




/*  
    echo "Type: ". $_FILES['picture']['type']."</br>";
    echo "Size: ". ($_FILES['picture']['size']/1024)."kb.</br>"; // Det er normalt vist i Bites, men vi dividere med 1024 for at få kilobytes
    echo "Stored: ". $_FILES['picture']['tmp_name']."</br>";
*/
