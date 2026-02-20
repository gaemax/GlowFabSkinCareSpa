<?php
session_start();

/* =========================
   AUTH CHECK (FIRST)
========================= */
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit;
}

/* =========================
   DESTROY SESSION
========================= */
$_SESSION = [];
session_unset();
session_destroy();

/* =========================
   PREVENT BACK BUTTON CACHE
========================= */
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

/* =========================
   REDIRECT AFTER LOGOUT
========================= */
header("Location: login.php?logout=success");
exit;
?>
