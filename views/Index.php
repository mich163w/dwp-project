<?php require('../Db/DBcon.php'); ?>

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
      $dbCon = new DbCon();

      $sql = "SELECT Profile.ProfileID, Profile.Username, Profile.Fname, Profile.Lname, Profile.Avatar, Media.URL, Media.mediaTitle, Media.mediaDesc
      FROM Profile
      JOIN Media ON Profile.ProfileID = Media.MediaProfileFK;";

      // Execute the query using $dbCon->dbCon
      $result = $dbCon->dbCon->query($sql);


      if ($result->rowCount() > 0) {
        // output data for hver række
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="col-md-3 grid-item">';
            echo '<img id="imageDisplay" width="324px" height="576px" src="' . $row["URL"] . '" alt="' . '">';
            echo '<div class="overlay" data-toggle="modal" data-target="#imageModal" data-username="' . $row['Username'] . '" data-desc="' . $row['mediaDesc'] . '" data-title="' . $row['mediaTitle'] . '" data-avatar="' . $row['Avatar'] . '">';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "0 resultater";
    }
        
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

