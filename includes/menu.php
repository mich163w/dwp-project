<div class="menubox">
    <a href="../views/index.php">
        <img id="logo" src="../BGimg/DrinkDBLogo.svg" alt="logo">
    </a>

    <div class="searchbar">
        <img id="searchicon" src="../BGimg/search.png" alt="searchIcon">
    </div>
    <div>
    <a href="../views/about.php">
        <button class="toLogin">About</button>
    </a>
    </div>

    <?php
require_once("../classes/SessionHandle.php");

$session = new SessionHandle();

if (!$session->logged_in()) {
    // Brug kun denne del, hvis brugeren ikke er logget ind
    ?>
    <a href="../views/frontpage.php">
        <button class="toLogin">Login</button>
    </a>
    <?php
}
?>


    <div class="settings">
        <a href="../views/profile.php">
            <img id="usericon" src="../BGimg/user.png" alt="userIcon">
        </a>
    </div>
</div>