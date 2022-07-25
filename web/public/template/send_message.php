<?php
$data = json_decode(file_get_contents('php://input'), true);
$message_text = $data['message'];
// check empty
if (strlen($message_text) == 0) die;
$table_name = $data['table'];
$sender = $_COOKIE['login'];
$receiver = $_COOKIE['receiver'];
$time = time();

$conn = new mysqli('mysql','root','root','messanger');
$co = $conn -> query("INSERT INTO $table_name(`time`, `message`, `sender`, `receiver`, `is_seen`) VALUES ('$time','$message_text','$sender','$receiver', 0)");