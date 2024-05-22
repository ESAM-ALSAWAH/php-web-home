<?php
session_start();
$isLogin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  header("Location: ./login.php");
  exit;
}

$username = htmlspecialchars($_SESSION["username"]);
?>
