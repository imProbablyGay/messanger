<?php
require '../core/common.php';

// get data array
$data = json_decode(file_get_contents('php://input'), true);
// create new chat id
$user = $data['user'];
$receiver = $data['receiver'];
execQuery("INSERT INTO `chats_id`(`user1`,`user2`) VALUES('$user','$receiver')");

// create new chat
$tableName = $data['table'];
execQuery("CREATE TABLE $tableName (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    time INT(11),
    message TEXT,
    sender VARCHAR(255),
    receiver VARCHAR(255),
    is_seen INT(1)
)");

// add directory for media
mkdir("../images/$tableName", 0777, true);
mkdir("../voice/$tableName", 0777, true);

// add id to user
$user_receivers = $data['receivers'];
$receiver = $data['receiver'];
$id = explode('_',$tableName)[1];
if (strpos($user_receivers, $id) === false && $user_receivers != 0) {
    $user_receivers.= ','.$id;
}
else if ($user_receivers == 0) {
    $user_receivers = $id;
}

// update user field
execQuery("UPDATE `users` SET `chat_id`='$user_receivers' WHERE `userName`='$user'");
// update receiver field
$receiverField = select("SELECT `chat_id` FROM users WHERE `userName`='$receiver'")[0]['chat_id'];
if (strpos($receiverField, $id) === false && $receiverField != 0) {
    $receiverField.= ','.$id;
}
else if ($receiverField == 0) {
    $receiverField = $id;
}
execQuery("UPDATE `users` SET `chat_id`='$receiverField' WHERE `userName`='$receiver'");