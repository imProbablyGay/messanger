<?php

if (isset($_POST['send'])) {
    $user_name = $_POST['userName'];
    $res = select("SELECT * FROM users WHERE userName = '$user_name'");
    
    if (count($res) == 0) {
        execQuery("INSERT INTO `users`(`userName`, `chat_id`,`online`) VALUES ('$user_name', 0,0)");
    } else {
        $date = time();
        execQuery("UPDATE `users` SET `online`=0 WHERE `userName`='$user_name'");
    }
    setcookie('login', $user_name);
    Header('Location: /');
}
require '_header.php';
?>

<div class="container" style='height:100vh;'>
    <div class="row form">
        <div class="form__login">
            <p>Войти в аккаунт</p>
            <form method='post'>
                <input type="text" name="userName" id="">
                <input type="submit" name="send" value="Логин">
            </form>
        </div>
    </div>
</div>