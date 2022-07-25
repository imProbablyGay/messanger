<?php
require '../core/common.php';
$data = json_decode(file_get_contents('php://input'), true);
$startID = $data['start_id'];
$tableName = $data['table'];

$getChat = select("SELECT * FROM $tableName WHERE id <= $startID ORDER BY id DESC LIMIT 20");

echo json_encode($getChat);