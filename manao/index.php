<?php session_start();

if ($_SESSION['user']) {
    header('Location: profile.php');
}

require_once('header.php');
?>

    <form>
        <label>Login</label>
        <input type="text" name="login" placeholder="Type Login">
        <label>Password</label>
        <input type="password" name="password" placeholder="Type Pass">
        <button type="submit" id="log-in">Log in</button>
        <p>
            Do you want to<a href="/register.php">Register?</a>
        </p>
        <div class="message"></div>
    </form>

<?php require_once('footer.php'); ?>
