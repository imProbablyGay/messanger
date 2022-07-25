<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>site.ru</title>
    <!-- css &js -->
    <link rel="stylesheet" href="../scss/style.css">
    <script src='../js/navbarLogic.js' defer></script>
    <script src='../js/updateOnline.js' defer></script>
    <script type='module' src='../js/checkIcon.js'></script>
    <!-- !@@@! -->
    <? if ($url == '/chat') {
      echo '
        <script src="../js/expandImg.js" defer></script>
      ';
    }
    else if ($url == '/changeicon') {
      echo '<link  href="../dist/cropper.css" rel="stylesheet">
      <script  type="module" src="../dist/cropper.js"></script>';
    }
    ?>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<header class="header">
    <!-- navbar -->
    <nav class="fixed-top navbar navbar-expand-lg">
        <div class="container">
          <?
          if ($url == '/chat') echo getReceiver();
          if ($url == '/') echo "<div class='navbar__search'><input type='text' placeholder='поиск'><div class='navbar__search-output'></div></div>";
          ?>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="bar bar-1"></div>
            <div class="bar bar-2"></div>
            <div class="bar bar-3"></div>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav navbar-nav-scroll" style='--bs-scroll-height:100vh;'>
              <li class="nav-item">
                <?=drawLogin()?>
                <script type='module'>
                  import {checkIcons} from '../js/checkIcon.js';
                  let icons = document.querySelectorAll('#icon-img');
                  checkIcons(icons);
                </script>
              </li>
            </ul>
          </div>
        </div>
      </nav>
</header>
