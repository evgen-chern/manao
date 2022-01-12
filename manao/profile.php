<?php
session_start();

if (!$_SESSION['user']) {
    header('Location: index.php');
}

require_once('header.php');
?>

    <h1 class="title">Hello <?=$_SESSION['user']['name'];?></h1>
    <a id="logout" href="vendor/logout.php">Log out</a>

<?php require_once('footer.php'); ?>