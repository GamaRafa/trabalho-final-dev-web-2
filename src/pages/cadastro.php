<?php
require_once '../core/autoload.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  extract($_POST);
  $usuario = new Usuario();
  $usuario->setNome(trim($nome));
  $usuario->setEmail(trim($email));
  $usuario->setSenha(password_hash($senha, PASSWORD_DEFAULT));
  $usuario->setEndereco(trim($endereco));

  if ($usuario->inserir() == true) {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $_SESSION["usuarioLogado"] = $usuario;
    $_SESSION["msgUsuarioCriado"] = "Usuário cadastrado com sucesso!";
    header("Location: jogos.php");
    exit();
  } else {
    $mensagem = "Problema ao cadastrar usuário";
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
  <script src="../core/validarForm.js"></script>
  <title>Soprando o Cartucho - Cadastro</title>
</head>
<body>
  <div class="page-content">
    <h1>Cadastro de Usuário</h1>
    <div class="form">
      <form method="post" onSubmit="return validarFormulario()" novalidate>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
    
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>
    
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required minlength="6">
    
        <label for="confirmar">Confirmar senha:</label>
        <input type="password" name="confirmar" id="confirmar" required>
    
        <label for="endereco">Endereço</label>
        <input type="text" name="endereco" id="endereco" required>
    
        <label>
          <input type="checkbox" name="termos" id="termos" required>
          Aceito os <a href="#">Termos de Uso</a>
        </label>
    
        <button type="submit">Cadastrar</button>
      </form>
        <br>
      <a href="login.php">
        <button type="button">Voltar</button>
      </a>
    </div>
  </div>
  <div>
    <p><?= $mensagem ?></p>
  </div>
  <?php require_once __DIR__ . '/footer.php'; ?>
</body>
</html>

<!-- falta os campos ficarem vermelhos -->