<?php
require '../core/common.php';

$data = json_decode(file_get_contents('php://input'), true);
$chatName = $data['chat'];
$user = $data['user'];
$receiver;
$chat = select("SELECT * FROM `$data[chat]` WHERE `id`=1");
if ($user == $chat[0]['sender']) {
    $receiver = $chat[0]['receiver'];
}
else if ($chat[0]['receiver'] == $user){
    $receiver = $chat[0]['sender'];
}

// time
$userData = select("SELECT `online` FROM users WHERE `userName`='$receiver'");
$time = "<p>В сети: ";
$date = time();
$userTime = $date - $userData[0]['online'];

if ($userTime < 60) $time .= 'только что</p>';
else if ($userTime < 3600) $time.=round($userTime/60).' мин. назад</p>';
else if ($userTime < 3600*24) $time.=round($userTime/3600).' ч. назад</p>';
else if ($userTime < 3600*24*31) $time.=round($userTime/3600/24).' д. назад</p>';
else if ($userTime == $date) $time = '<p class="online">В сети</p>';
else if ($userTime >= 3600*24*31) $time.=' давно</p>';

$output = [
    'receiver' => $receiver,
    'id' => $chatName,
    'time' => $time
];

echo json_encode($output);

