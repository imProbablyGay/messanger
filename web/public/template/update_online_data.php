<?php
require '../core/common.php';
$user_name = $_COOKIE['login'];
setcookie('newChat', null, -1, '/'); 

$date = time();
execQuery("UPDATE `users` SET `online`=$date WHERE `userName`='$user_name'");