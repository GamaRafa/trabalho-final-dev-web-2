<?php
require_once __DIR__ . '/../core/conexao.php';

class Usuario {
  use DataAccess;

  private $id;
  private $nome;
  private $email;
  private $senha;
  private $endereco;
  private $data_cadastro;

  public function inserir() {
    $pdo = conexao();
    $sql = "INSERT INTO usuarios (
      nome, email, senha, endereco
    ) VALUES (
      :nome, :email, :senha, :endereco
    )";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":senha", $this->senha);
    $stmt->bindParam(":endereco", $this->endereco);

    return $stmt->execute();
  }
}