<?php
require_once __DIR__ . '/../core/conexao.php';

$mensagemErro = "";

function buscarUsuario($email) {
  $pdo = conexao();
  $sql = "SELECT * FROM usuarios WHERE email = :email";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST["email"])) {
  $emailInformado = $_POST["email"];
  $senhaInformada = $_POST["senha"];
  $usuario = buscarUsuario($emailInformado);

  if ($usuario && $usuario["senha"] == $senhaInformada) {
    session_start();
    $_SESSION['usuarioLogado'] = $usuario;
    header("Location: jogos.php");
  } else {
    $mensagemErro = "E-mail ou senha incorretos";
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
  <title>Soprando o cartucho - Login</title>
</head>
<body>

  <h1>Soprando o Cartucho - Login</h1>
  <form method="post">
    <label for="usuario">E-mail:</label>
    <input type="text" name="email" required>
    <br>
    <label for="senha">Senha:</label>
    <input type="password" name="senha" required>
    <br>
    <button type="submit">Login</button>
  </form>

  <?php if(!empty($mensagemErro)): ?>
  <div>
    <p class="error"><?= $mensagemErro ?></p>
  </div>
  <?php endif ; ?>

  <img src="../assets/imgs/old-video-game-cartoon_9044-81.jpg" alt="Foto1" id="imgLogin">
</body>
</html>