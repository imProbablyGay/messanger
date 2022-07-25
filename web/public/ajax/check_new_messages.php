<?php
require '../core/common.php';

$out;
$data = json_decode(file_get_contents('php://input'), true);
$chat = $data['table'];
$receiver = $data['receiver'];
$newMessages = select("SELECT * FROM `$chat` WHERE `is_seen`= 0 AND `sender` = '$receiver'");

foreach($newMessages as $item) {
    $out[] = $item['message'];
}

$out = json_encode($out);
print_r($out);


// update is_seen
execQuery("UPDATE `$chat` SET `is_seen`=1 WHERE `is_seen`=0 AND `sender` = '$receiver'");
