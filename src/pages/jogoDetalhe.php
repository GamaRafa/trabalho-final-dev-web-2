<?php
require_once __DIR__ . '/../core/conexao.php';

function getJogoById($id) {
  $pdo = conexao();
  $sql = "SELECT * FROM jogos WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

$jogo = getJogoById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/index.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <title>Document</title>
</head>
<body>
  <?php include_once __DIR__ . '/header.php'; ?>
  <div class="page-content">
    <h2><?= htmlspecialchars($jogo["nome"]) ?></h1>
    <p><strong>Descrição:</strong> <?= htmlspecialchars($jogo["descricao"]) ?></p>
    <p><strong>Plataforma:</strong> <?= htmlspecialchars($jogo["plataforma"]) ?></p>
    <p><strong>Preço:</strong> R$ <?= number_format($jogo["preco"], 2, ',', '.') ?></p>
    <p><strong>Estoque:</strong> <?= htmlspecialchars($jogo["estoque"]) ?></p>
    <br>
    <p><a href="jogos.php">← Voltar à lista de jogos</a></p>
    <a href="carrinho.php?add=<?= $jogo["id"] ?>" class="btn">Adicionar ao carrinho</a>
  </div>
  <?php include_once __DIR__ . '/footer.php'; ?>
</body>
</html>