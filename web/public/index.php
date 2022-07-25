<?php
require 'core/common.php';

// routing
require 'core/Routing.php';
$url = $_SERVER['REQUEST_URI'];
$r = new Router();
$r->addRoute("/","main.php");
$r->addRoute("/login","login.php");
$r->addRoute("/logout","logout.php");
$r->addRoute("/chat","chat.php");
$r->addRoute("/changeicon","change_icon.php");

// check login
$a = checkLogin();
if (!$a) {
    $r->route('/login');
    die;
}

$r->route($url);