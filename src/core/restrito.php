<?php
session_start();

if (!isset($_SESSION["usuarioLogado"])) {
  header("Location: login.php");
  exit();
}