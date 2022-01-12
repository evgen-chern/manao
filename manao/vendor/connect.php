<?php
$connect = mysqli_connect('localhost', 'root', '', 'manao');

if (!$connect) {
    die('Error connect to DB');
}
