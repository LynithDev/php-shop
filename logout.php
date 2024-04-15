<?php
    require_once 'helpers/user_helper.php';
    require_once 'layout.php';

    logout();

    header("Location: /");
    exit;
?>