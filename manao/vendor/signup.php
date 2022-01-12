<?php
session_start();
require_once 'connect.php';

$login = $_POST['login'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$salt = "thissaltysalt";
$error_fields = [];
$check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");

if(mysqli_num_rows($check_login)>0){
    $response = [
      "status" => false,
        "type" => 1,
        "message" => "login exists",
        "fields" => ['login']
    ];
    echo json_encode($response);
    die();
}

if(strlen($login) <= 6){
    $error_fields[] = 'login';
}
if(strlen($password) <= 6){
    $error_fields[] = 'password';
}
if($confirm_password === ''){
    $error_fields[] = 'confirm_password';
}
if(strlen($name) <= 2){
    $error_fields[] = 'name';
}
if($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error_fields[] = 'email';
}


if(!empty($error_fields)) {
    $response = [
        "status" => false,
        "type" => 1,
        "message" => "fill fields",
        "fields" => $error_fields,
    ];

    echo json_encode($response);

    die();
}


if ($password === $confirm_password) {

    $password = md5($salt.$password);

    mysqli_query($connect, "INSERT INTO `users` (`id`, `login`, `name`, `email`, `password`) VALUES (NULL, '$login', '$name', '$email', '$password')");

    $response = [
        "status" => true,
        "message" => "Congratulations",
    ];
    echo json_encode($response);

} else {
    $response = [
        "status" => false,
        "message" => "PASSWORD MISMATCH",
    ];
    echo json_encode($response);
}