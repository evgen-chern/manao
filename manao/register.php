<?php session_start();

if ($_SESSION['user']) {
    header('Location: profile.php');
}

require_once('header.php');
?>

<form>
    <label>Login</label>
    <input type="text" name="login" placeholder="Type Login">

    <label>Name</label>
    <input type="text" name="name" placeholder="Type Name">

    <label>Email</label>
    <input type="email" name="email" placeholder="Type Your Email">

    <label>Password</label>
    <input type="password" name="password" placeholder="Type Pass">

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" placeholder="Type Pass Again">
    <button type="submit" id="reg-in">Register</button>
    <p>
        Do you want to<a href="/">Log in?</a>
    </p>
    <div class="message"></div>
</form>

<?php require_once('footer.php'); ?>
