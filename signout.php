<?php
    session_start();
    unset($_SESSION['user']);
    session_destroy();
    setcookie("user", "", time() - 3600, "/");
    header('Location: ./views/auth/login.php');
?>