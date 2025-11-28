<?php

function conexao() {
  $dsn = "mysql:host=db;dbname=sopra_cartucho;charset=utf8";
  $usuario = "user";
  $senha = "SopraCart123#";

  try {
    $pdo = new PDO($dsn, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    exit;
  }
}