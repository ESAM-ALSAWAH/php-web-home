<?php
session_start();

if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== FALSE) {
  header("Location: ./login.php");
  exit;
}
?>