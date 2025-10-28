<?php
require_once __DIR__ . '/../core/conexao.php';

function getJogos() {
  $pdo = conexao();
  $sql = "SELECT * FROM jogos";
  $stmt = $pdo->query($sql);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$jogos = getJogos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/index.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <title>Test</title>
</head>
<body>
  <ul>
    <?php foreach ($jogos as $jogo): ?>
    <li>
      <a href="jogoDetalhe.php?id=<?= urldecode($jogo['id']) ?>">
        <strong><?= $jogo["nome"] ?></strong>
      </a>
      <p><?= $jogo["descricao"] ?></p>
      <p><?= $jogo["plataforma"] ?></p>
      <p><?= $jogo["preco"] ?></p>
      <p><?= $jogo["estoque"] ?></p>
    </li>
    <?php endforeach ; ?>
  </ul>
</body>
</html>