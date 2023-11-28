<?php require('../Db/connection.php'); ?>

<!DOCTYPE html>
<title>Index</title>
<html lang="en">

<?php require("../includes/header.php"); ?>


<body>
    <?php require("../includes/menu.php"); ?>

    <div class="content">
        <button id="myBtn">+</button>

        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <form method="post" id="modalform" action="../logic/mediaInsert.php" enctype="multipart/form-data">
                    <div class="modalbox">
                        <div class="modalLeft">
                            <input class="uploadBtn" type="file" name="picture">
                        </div>
                        <div class="modalRight">
                            <label for="Title">Title</label>
                            <input class="mTitle" type="text" name="mediaTitle">
                            <label for="Description">Description</label>
                            <input class="mDesc" type="text" name="mediaDesc" rows="10" col="25">
                            <input type="hidden" name="userAvatar" value="<?php echo $row['Avatar']; ?>">
                            <input type="submit" class="submitBtn" name="submit" value="Submit" />
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>







    <div class="imageModal">
        <?php
        $sql = "SELECT Profile.ProfileID, Profile.Username, Profile.Fname, Profile.Lname, Profile.Avatar, Media.URL, Media.mediaTitle, Media.mediaDesc
        FROM Profile
        JOIN Media ON Profile.ProfileID = Media.MediaProfileFK;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data for hver række
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-3 grid-item">';
                echo '<img id="imageDisplay" width="324px" height="576px" src="' . $row["URL"] . '" alt="' . '">';
                echo '<div class="overlay" data-toggle="modal" data-target="#imageModal" data-username="' . $row['Username'] . '" data-desc="' . $row['mediaDesc'] . '" data-title="' . $row['mediaTitle'] . '" data-avatar="' . $row['Avatar'] . '">';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "0 resultater";
        }
        $conn->close();
        ?>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popupLeft">
                        <img src="" class="img-fluid" id="modalImage" alt="image" width="170px" height="300px" ;>
                    </div>
                    <div class="popupRight">
                        <div class="imgProfileDisplay">
                            <img src="" class="img-fluid" id="modalAvatar" alt="avatar" width="30px" height="30px" ;>
                            <span id="modalUsername"></span>
                        </div>
                        <h5 id="modalTitle"></h5>
                        <p id="modalDescription"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.grid-item').click(function() {
                var imgSrc = $(this).find('img').attr('src');
                var username = $(this).find('.overlay').data('username');
                var description = $(this).find('.overlay').data('desc');
                var title = $(this).find('.overlay').data('title');
                var avatar = $(this).find('.overlay').data('avatar');
                $('#modalImage').attr('src', imgSrc);
                $('#modalUsername').text(username);
                $('#modalTitle').text(title);
                $('#modalDescription').text(description);
                $('#modalAvatar').attr('src', avatar);
                $('#imageModal').modal('show');
            });
        });
    </script>

</body>

</html>






</div>
















<?php require("../includes/footer.php"); ?>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>


</html>


<?php
/*
                    $query = "SELECT * FROM `Likess`";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="User-upload">
                            <?php echo $row['LikeID']; ?> Likes


                        </div>
                    <?php
                    }
                    mysqli_close($conn);




                    $sqlUsername = "SELECT Media.MediaID, Media.URL, Media.mediaTitle, Media.mediaDesc, Media.mediaComment, Media.mediaLike, Profile.Username 
                    FROM Media 
                    JOIN Profile ON Media.MediaProfileFK = Profile.ProfileID";


                        $sqlUsername = "SELECT Profile.Username 
                                FROM Media 
                                JOIN Profile ON Media.MediaProfileFK = Profile.ProfileID
                                WHERE Media.MediaProfileFK = $ProfileID";












   <!-- Your PHP code to display images -->
        <?php
        $display = "SELECT * FROM `Media`";
        $result = mysqli_query($conn, $display);
        while ($row = mysqli_fetch_array($result)) { ?>
            <img src="<?php echo $row['URL']; ?>" onclick="openModal('<?php echo $row['URL']; ?>')" alt="image" id="imageDisplay" style="width: 324px; height: 576px;">
        <?php }
        
        ?>

        <!-- The Modal -->
        <div id="customModal" class="modal-container">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>

                <div class="ImgPopup">

                    <div class="PopupLeft">
                        <div class="imgContainer">
                            <img id="modalImage" style="width: 370px; height: 659px; padding:1.5%;">
                        </div>
                    </div>

                    <div class="PopupRight">

                    </div>

                </div>

            </div>
        </div>
















                <?php
                // Assuming $conn is the established database connection
                $MediaID = 1;
                $ProfileID = 1;


                $test = "SELECT Profile.Username, Media.* 
                FROM Media 
                INNER JOIN Profile ON Media.MediaProfileFK = Profile.ProfileID 
                WHERE Media.MediaProfileFK = $MediaID";


                $sqlUsername = "SELECT Profile.Username 
                FROM Media 
                JOIN Profile ON Media.MediaProfileFK = Profile.ProfileID
                WHERE Media.MediaProfileFK = $ProfileID";



                $result = mysqli_query($conn, $test);
                if (!$result) {
                    die("Forespørgslen fejlede: " . mysqli_error($conn));
                }
                
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    echo $row['Username'] . "<br>";
                } else {
                    echo "Ingen resultater fundet for det angivne MediaID.";
                }

                // Don't close the connection here
                // mysqli_close($conn);
                ?>











                // Udfør en forespørgsel for at hente billed-URL'er
$sql = "SELECT URL, mediaTitle, mediaDesc FROM Media"; // Antagelse af at din tabel med billeder hedder Media
$result = $conn->query($sql);
while ($row = mysqli_fetch_array($result)) { ?>
    <img src="<?php echo $row['URL']; ?>" onclick="openModal('<?php echo $row['URL']; ?>')" alt="image" id="imageDisplay" style="width: 324px; height: 576px;">
<?php }

?>

<!-- The Modal -->
<div id="customModal" class="modal-container">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>

        <div class="ImgPopup">

            <div class="PopupLeft">
                <div class="imgContainer">
                    <img id="modalImage" style="width: 370px; height: 659px; padding:1.5%;">
                </div>
            </div>

            <div class="PopupRight">

            </div>

        </div>

    </div>
</div>










    <?php
        $display = "SELECT * FROM `Media`";
        $result = mysqli_query($conn, $display);
        while ($row = mysqli_fetch_array($result)) { ?>
            <img src="<?php echo $row['URL']; ?>" alt="image" id="myImg" style="width: 324px; height: 576px;">
        <?php }
        
        ?>


<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>
                */
?>
