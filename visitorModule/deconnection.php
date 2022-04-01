<?php
    session_start();
    session_unset();
    header('Location: connection.php');
    exit();
?>