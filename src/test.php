<?php
require_once 'conexao.php';

function getJogos() {
  $pdo = conexao();
  $sql = "SELECT * FROM jogos";
  $stmt = $pdo->query($sql);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$jogos = getJogos();
// nome, descricao, plataforma, preco, estoque, imagem
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test</title>
</head>
<body>
  <ul>
    <?php foreach ($jogos as $jogo): ?>
    <li>
      <strong><?= $jogo["nome"] ?></strong>
      <p><?= $jogo["descricao"] ?></p>
      <p><?= $jogo["plataforma"] ?></p>
      <p><?= $jogo["preco"] ?></p>
      <p><?= $jogo["estoque"] ?></p>
    </li>
    <?php endforeach ; ?>
  </ul>
</body>
</html>