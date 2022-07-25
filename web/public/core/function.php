<?php

function connect(){
    $conn = mysqli_connect(SERVER, USERNAME, PASSWORD, DB);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    return $conn;
}

function select($query) {
    global $conn;
    $queryResult = [];
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $queryResult[] = $row;
        }
    }
    return $queryResult;
}

function execQuery($query) {
    global $conn;
    if (mysqli_query($conn, $query)){
        return true;
    }
    DBerror($query, mysqli_error($conn),mysqli_errno($conn));
    return false;
}

function DBerror($query,$msg,$errno){
    echo "<b> MySQL error".$errno."<br>".htmlspecialchars($msg)."<br>".$query."<hr>";
    }

function drawLogin() {
    $out = '';

    // check cookie
    if ($_COOKIE['login']) {
        $user = select("SELECT * FROM users WHERE userName = '$_COOKIE[login]'");

        if ($user) {
            $out = '<div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                   <img id="icon-img" src="../images/user_icons/'.$user[0]['userName'].'.jpeg">
                        '.$user[0]['userName'].'
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item logout-btn" href="/logout">Выйти</a>
                    <a class="dropdown-item change-icon-btn" href="/changeicon">Поменять иконку</a>
                    </ul>
                </div>';
        }
    }
   
    if ($out == '')  $out = "<a href='/login'>Логин</a>";

    return $out;
}

function checkLogin() {
    $user= $_COOKIE['login'];
    if ($user) {
        $user = select("SELECT * FROM users WHERE userName = '$user'");
        if (empty($user)) {
            return false;
        }
        else {
            return true;
        }
    }

    return false;
}

function getReceiver() {
    $receiver = $_COOKIE['receiver'];

    return "<span class='navbar__receiver'>$receiver</span>";
}

