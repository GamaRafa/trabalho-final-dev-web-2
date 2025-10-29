<?php
require_once __DIR__ . '/../core/restrito.php';
require_once __DIR__ . '/../core/autoload.php';

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!isset($_SESSION["carrinho"])) {
  $_SESSION["carrinho"] = [];
}

$pdo = conexao();

// adicionar ao carrinho
if (isset($_GET["add"])) {
  $id = $_GET["add"];
  if (isset($_SESSION["carrinho"][$id])) {  // se o item já tá no carrinho
    $_SESSION["carrinho"][$id]++; // incrementa a quantidade
  } else {
    $_SESSION["carrinho"][$id] = 1;
  }
  header("Location: carrinho.php");
  exit;
}

// remover item
if (isset($_GET["remove"])) {
  $id = $_GET["remove"];
  unset($_SESSION["carrinho"][$id]);
  header("Location: carrinho.php");
  exit;
}

// limpar carrinho
if (isset($_GET["clear"])) {
  $_SESSION["carrinho"] = [];
  header("Location: carrinho.php");
  exit;
}

$itens = [];
$total = 0;

if (!empty($_SESSION["carrinho"])) {
  $ids = implode(',', array_keys($_SESSION["carrinho"]));
  if (!empty($ids)) {
    $stmt = $pdo->query("SELECT * FROM jogos WHERE id IN ($ids)");
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  $itensCompletos = [];

  foreach ($itens as $item) {
    $id = $item["id"];
    $item["quantidade"] = $_SESSION["carrinho"][$id];
    $item["subtotal"] = $item["preco"] * $item["quantidade"];
    $total += $item["subtotal"];
    $itensCompletos[] = $item;
  }
  $itens = $itensCompletos;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/index.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <title>Soprando o Cartucho - Carrinho</title>
</head>
<body>
  <?php include_once __DIR__ . '/header.php'; ?>

  <div class="page-content">
  <h2>Seu Carrinho</h2>
  <?php if (empty($itens)): ?>
    <p style="text-align:center">Seu carrinho está vazio</p>
  <?php else: ?>
    <ul>
      <?php foreach ($itens as $item): ?>
        <li>
          <strong><?= $item["nome"] ?></strong>
          <br>
          <p>Quantidade: <?= $item["quantidade"] ?></p>
          <br>
          <p>Subtotal: <?= number_format($item["subtotal"], 2, ",", ".") ?></p>
          <br>
          <a href="?remove=<?= $item["id"] ?>" class="btn">Remover</a>
        </li>
      <?php endforeach; ?>
    </ul>
    <h3>Total: R$ <?= number_format($total, 2, ",", ".") ?></h3>
    <a href="?clear=true" class="btn">Esvaziar Carrinho</a>
  <?php endif; ?>
  </div>

  <?php include_once __DIR__ . '/footer.php'; ?>
</body>
</html>