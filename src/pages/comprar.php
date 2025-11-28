<?php
require_once '../core/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require '/var/www/vendor/autoload.php';
require $_SERVER["HOME"] . '/vendor/autoload.php';
$pdo = conexao();

// $dotenv = Dotenv\Dotenv::createImmutable('/var/www');
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER["HOME"]);
$dotenv->load();

$mail = new PHPMailer(true);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$usuario = $_SESSION["usuarioLogado"];
$userEmail = $usuario["email"];
$userName = $usuario["nome"];
$carrinho = $_SESSION["carrinho"];

$itens = [];
$total = 0;

if (!empty($carrinho)) {
  $ids = implode(',', array_keys($carrinho));
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

try {
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  $mail->Username = $_ENV['SMTP_USER'];
  $mail->Password = $_ENV['SMTP_PASS'];
  $mail->SMTPSecure = 'tls';
  $mail->Host = $_ENV['SMTP_HOST'];
  $mail->Port = $_ENV['SMTP_PORT'];

  $mail->CharSet = 'UTF-8';
  $mail->Encoding = 'base64';


  $mail->setFrom($_ENV['SMTP_USER'], "Soprando o Cartucho");
  $mail->addAddress($userEmail, $userName);
  $mail->isHTML(true);
  $mail->Subject = "Confirmação de Compra - Soprando o Cartucho";
  $mail->Body    = "Olá $userName,<br><br>
  Sua compra foi realizada com sucesso!<br><br>
  Você comprou os seguintes jogos:<br><br>
  " . implode("<br>", array_map(function($item) {
    return $item['nome'] . " (Quantidade: " . $item['quantidade'] . ")";
  }, $itens)) . "<br><br>
  O total da compra foi R$ " . number_format($total, 2, ",", ".") . ".<br><br>
  Em breve entraremos em contato para o envio dos seus jogos.<br><br>
  Atenciosamente,<br>
  Equipe Soprando o Cartucho";
  $mail->AltBody = "Olá $userName,\n\n
  Sua compra foi realizada com sucesso!\n\n
  Você comprou os seguintes jogos:\n\n
  " . implode("\n", array_map(function($item) {
    return $item['nome'] . " (Quantidade: " . $item['quantidade'] . ")";
  }, $itens)) . "\n\n
  O total da compra foi R$ " . number_format($total, 2, ",", ".") . ".\n\n
  Em breve entraremos em contato para o envio dos seus jogos.\n\n
  Atenciosamente,\n
  Equipe Soprando o Cartucho";

  $mail->send();
  
  header("Location: carrinho.php?clear=true");
  exit;
} catch (Exception $e) {
  echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
}
