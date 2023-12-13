src="https://code.jquery.com/jquery-3.6.4.min.js"
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"

$(document).ready(function() {
    $('.grid-item').click(function() {
        var MediaID = $(this).find('.overlay').data('media')
        var imgSrc = $(this).find('img').attr('src');
        var username = $(this).find('.overlay').data('username'); //Eksempel på hvad disse gør: opretter en variabel ved navn "username". Her bruges jQuery for at finde et element med klassen ".overlay" i det element, der udløser begivenheden. Derefter bruges .data('username') til at få værdien af attributten 'username' fra dette element. Denne værdi bliver gemt i variablen "username".
        var description = $(this).find('.overlay').data('desc');
        var title = $(this).find('.overlay').data('title');
        var avatar = $(this).find('.overlay').data('avatar');
        var hiddenMediaID = $(this).find('.overlay').data('MediaID');
        $('#modalImage').attr('src', imgSrc);
        $('#modalUsername').text(username); //Finder et HTML-element med id'et 'modalUsername'. Vi indstiller teksten af dette element til værdien af variablen "username", der vises i modalboksen
        $('#modalTitle').text(title);
        $('#modalDescription').text(description);
        $('#modalAvatar').attr('src', avatar);
        $('#imageModal').modal('show');
        $('#hiddenMediaID').val(MediaID);
        $('#likeProfile').val(MediaID);
        $('#likeMedia').val(MediaID);
        console.log("Media ID: ", MediaID)
        console.log("værdi sat: ", $('#hiddenInputMediaID').val())
        var hiddenInputMediaID = $(this).find('.overlay').data('MediaID');
        $('#hiddenInputMediaID').val(hiddenInputMediaID);
        var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4) {
        if (this.status == 200) {
            document.getElementById("comments").innerHTML = this.responseText;
        } else {
            console.error("Error loading comments:", this.status, this.statusText);
        }
    }
};
xmlhttp.open("GET", "../logic/getComments.inc.php?MediaID=" + MediaID, true);
xmlhttp.send();

    });
});
// Get the modal
let modal = document.getElementById("myModal");
// Get the button that opens the modal
let btn = document.getElementById("myBtn");
console.log("btn", btn)
// Get the <span> element that closes the modal
let span = document.getElementsByClassName("close")[0];
// Brug jQuery til at åbne modalen
$('#myBtn').on('click', function() {
    console.log("test click to open");
    $('#myModal').modal('show');
}); 

// Brug Bootstrap-modalhændelser til at lukke modalen
$('#myModal').on('hidden.bs.modal', function () {
    console.log("test click to close");
    // Yderligere oprydning eller handlinger efter modalen er lukket
});

// When the user clicks anywhere outside of the modal, close it
window.addEventListener('click', function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
});

$(document).ready(function() {
    // Når brugeren klikker på "Like"
    $('.like-button').on('click', function() {
        handleLikeOrDislike(1, $(this), '../logic/like.php');
    });
    // Når brugeren klikker på "Dislike"
    $('.dislike-button').on('click', function() {
        handleLikeOrDislike(-1, $(this), '../logic/like.php');
    });

    function handleLikeOrDislike(action, $button, actionFile) {
        var postid = $button.closest('.likeButtons').data('media-id');
        var likesCount = $button.closest('.likeButtons').data('likes');
        $.ajax({
            url: actionFile,
            type: 'post',
            data: {
                'like_action': action,
                'postid': postid
            },
            success: function(response) {
                // Opdater likes-tællingen i modalen
                $('#imageModal').find('.likes_count_modal').text(response + ' likes');
                // Opdater likes-tællingen i overlay-elementet
                $button.closest('.likeButtons').data('likes', response);
            }
        });
    }
});
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("gallery-item")) {
        const src = e.target.getAttribute("src");
        document.querySelector(".modal-img").src = src;
        const myModal = new bootstrap.Modal(document.getElementById('gallery-modal'));
        myModal.show();
    }
})


 // Get the modal
 //var modal = document.getElementById("myModal");
/* 
 // Get the button that opens the modal
 var btn = document.getElementById("myBtn");

 // Get the <span> element that closes the modal
 var span = document.getElementsByClassName("close")[0];

 // When the user clicks on the button, open the modal
 btn.addEventListener('click', function() {
    console.log("test click to open")
    modal.style.display = "block";
}); 
// When the user clicks on <span> (x), close the modal
btn.addEventListener('click', function() {
    console.log("test click to open")
    modal.style.display = "none";
}); 

 // When the user clicks anywhere outside of the modal, close it
 window.onclick = function(event) {
     if (event.target == modal) {
         modal.style.display = "none";
     }
 } */
/* 

 document.addEventListener("click",function (e){
   if(e.target.classList.contains("gallery-item")){
   	  const src = e.target.getAttribute("src");
   	  document.querySelector(".modal-img").src = src;
   	  const myModal = new bootstrap.Modal(document.getElementById('gallery-modal'));
   	  myModal.show();
   }
 })

 */

