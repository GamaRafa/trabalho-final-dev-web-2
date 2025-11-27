<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

$mail = new PHPMailer(true);
$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome = trim($_POST["nome"]);
  $email = trim($_POST["email"]);
  $assunto = trim($_POST["assunto"]);
  $mensagem = trim($_POST["mensagem"]);

  try {
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USER'];
    $mail->Password = $_ENV['SMTP_PASS'];
    $mail->SMTPSecure = 'tls';
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->Port = $_ENV['SMTP_PORT'];
  
    $mail->setFrom($_ENV['SMTP_USER'], "Soprando o Cartucho");
    $mail->addAddress($email, $nome);
    $mail->isHTML(true);
    $mail->Subject = $assunto;
    $mail->Body    = nl2br("Olá $nome,<br><br>
    Recebemos sua mensagem:<br><br>
    $mensagem<br><br>
    Entraremos em contato em breve.<br><br>
    Atenciosamente,<br>
    Equipe Soprando o Cartucho");
    $mail->AltBody = "Olá $nome,\n\n
    Recebemos sua mensagem:\n\n
    $mensagem\n\n
    Entraremos em contato em breve.\n\n
    Atenciosamente,\n
    Equipe Soprando o Cartucho";
    
    $mail->send();
    $msg = "Mensagem enviada com sucesso!";
  } catch (Exception $e) {
    $msg = "Erro ao enviar mensagem: {$mail->ErrorInfo}";
  }
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
  <title>Soprando o Cartucho - Fale conosco</title>
</head>
<body>
  <?php include_once __DIR__ . '/header.php'; ?>
  <div class="page-content">
    <h1>Fale Conosco</h1>
    <div class="form">
      <form method="post" onsubmit="return validarFormulario()" novalidate>
        <label for="nome">Nome: </label>
        <input type="text" name="nome" id="nome" required>

        <label for="email">E-mail: </label>
        <input type="email" name="email" id="email" required>

        <label for="assunto">Assunto: </label>
        <input type="text" name="assunto" id="assunto" required>

        <label for="mensagem">Mensagem: </label>
        <textarea name="mensagem" id="mensagem" rows="5" required></textarea>

          <button type="submit">Enviar</button>
        </form>
        <?php if (!empty($msg)): ?>
           <span><?= $msg ?></span>
        <?php endif; ?>
    </div>
  </div>
  
  <script>
    function validarFormulario() {
      let campos = Array.from(document.querySelectorAll("input[required]"));
      let textareas = Array.from(document.querySelectorAll("textarea[required]"));
      let valido = true;

      campos.push(...textareas);

      campos.forEach(campo => {
        if (!campo.value.trim()) {
          campo.classList.add("campoInvalido");
          valido = false;
        } else {
          campo.classList.remove("campoInvalido");
        }
      });
      return valido;
    }
  </script>
  <?php include_once __DIR__ . '/footer.php'; ?>
</body>
</html>