<?php
setcookie('login', null, -1, '/'); 
setcookie('receiver', null, -1, '/'); 
setcookie('newChat', null, -1, '/'); 
Header('Location: /login');
?>