<?php

class Router
{
    private $pages = [];

    function addRoute($url, $path) {
        $this->pages[$url] = $path;
    }

    function route($url) {
        $path = $this->pages[$url];
        $file_dir = "template/".$path;
        if ($path == '') {
            require "./template/404.php";
            die();
        }

        if (file_exists($file_dir)) {
            require $file_dir;
        } else {
            require "./template/404.php";
            die();
        }
    }
}