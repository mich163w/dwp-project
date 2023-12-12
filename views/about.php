<?php
spl_autoload_register(function ($class) {
    include_once "../classes/" . $class . ".php";
});

?>

<!DOCTYPE html>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">

<html lang="en">

<?php require("../includes/header.php"); ?>

<body>
    <?php require("../includes/menu.php"); ?>

    <div class="tekst">
        <h3>Our Story</h3>
        <p class="omospara">SipCheer was founded with a simple idea in mind – to create a digital community that celebrates life's small joys and honors the unforgettable moments that happen during a night out on the town. We believe that the best memories are made around a table filled with smiling faces, colorful drinks, and the great vibes that arise when friends come together. Thus, we decided to create an online space that makes it easy to share these moments with the world – welcome to SipCheer!</p>

        <h3>Our Mission</h3>
        <p class="omospara">Our mission is to inspire people to share their nightlife moments and create a community where everyone can find inspiration, encouragement, and connect with like-minded individuals. We believe that every picture tells a story, and when it comes to nightlife snapshots, those stories are filled with fun, laughter, friendship, and, of course, a good cocktail or two. By sharing these snapshots of joy and celebration, we aim to create a virtual space where people can join in each other's festivities and become part of the larger SipCheer community.</p>

        <h3>What Makes SipCheer Unique?</h3>
        <p class="omospara">At SipCheer, we are passionate about creating a platform that is not only a place to share pictures but also a source of inspiration, tips, and ideas for the next night out. We want to highlight the diversity of drinks, friends, and experiences found around the world. Whether you prefer an elegant cocktail at a rooftop bar or a casual beer at your favorite pub, there's room for everyone on SipCheer.</p>
    </div>
</body>

</html>

<style>
    .tekst {
        padding-top: 7.5%;
        margin-left: 2%;
        width: 70vw;
        font-family: 'Montserrat', sans-serif;
        font-weight: lighter;
    }

    .omospara {
        margin-bottom: 5%;
    }
</style>