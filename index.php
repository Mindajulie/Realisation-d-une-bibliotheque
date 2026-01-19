<?php
session_start();


if (!isset($_SESSION)) {
    die("Session non démarrée");
}


if (!isset($_SESSION["user_id"])) {
    header("Location: /biblio/auth/login.php");
    exit;
}


if ($_SESSION["role"] === "admin") {
    header("Location: /biblio/dashboard/admin/index.php");
    exit;
}


header("Location: /biblio/dashboard/user/index.php");
exit;
