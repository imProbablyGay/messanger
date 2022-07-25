<?php
require '../core/common.php';
$login = json_decode(file_get_contents('php://input'), true)['login'];
$out = select("SELECT chat_id FROM users WHERE userName = '$login'")[0]['chat_id'];

echo $out;