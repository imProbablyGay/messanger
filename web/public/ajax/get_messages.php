<?php
require '../core/common.php';
$data = json_decode(file_get_contents('php://input'), true);
$message = $data['message'];
$login = trim($data['login']);

if ($message == '0') {
    echo json_encode([]);
    exit;
}

// get table id
$arr = explode(',', $message);
for ($i = 0; $i < count($arr); $i++) {
    $table = 'chat_'.$arr[$i];
    $messageCount[] = [
        count(select("SELECT `id` FROM `$table` WHERE `is_seen` = 0 && `sender` != '$login'")),
        $arr[$i]
    ];
}

echo json_encode($messageCount);