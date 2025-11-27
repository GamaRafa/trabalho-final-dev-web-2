<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/index.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <title>Soprando o Cartucho - Quiz</title>
</head>
<body>
  <?php include 'header.php'; ?>
  <div class="page-content">
    <h1>Soprando o Cartucho - Quiz</h1>
    <div  class="quiz-header">
      <p>
      Bem-vindo ao quiz da loja <strong>Soprando o Cartucho</strong>!
      Você quer testar seus conhecimentos sobre personagens clássicos dos videogames?
      </p>
      <button type="button" onclick="gerarPerguntas()">Começar!</button>
    </div>
    
    <div class="quiz-container" id="quiz-container">
      <!-- O quiz será carregado aqui via JavaScript -->
    </div>
  </div>
  <?php include 'footer.php'; ?>
  <script>
    let gabarito = [];

    async function gerarPerguntas() {
      const quizContainer = document.getElementById('quiz-container');
      quizContainer.innerHTML = "<p>Carregando perguntas...</p>";

      try {
        const response = await fetch('api.php');
        if (!response.ok) {
          throw new Error('Erro na requisição: ' + response.statusText);
        }

        const perguntas = await response.json();
        gabarito = perguntas;
        let quizHTML = '';

        perguntas.forEach((p, index) => {
          quizHTML += `
            <div class="quiz-question">
              <h3>Questão ${index + 1}: ${p.questao}</h3>
              <div class="quiz-answers">
          `;

          for (let letra in p.respostas) {
            quizHTML += `
              <label>
                <input type="radio" name="questao${p.idQuestao}" value="${letra}">
                ${letra}: ${p.respostas[letra]}
              </label><br>
            `;
          }

          quizHTML += `
              </div>
            </div>
            <hr>
          `;
        })

        quizHTML += `
          <button type="button" onclick="corrigirQuiz()">
            Enviar Respostas
          </button>
          <div id="resultado-quiz"></div>
        `;

        quizContainer.innerHTML = quizHTML;
      } catch (erro) {
        quizContainer.innerHTML = `<p>Erro ao carregar perguntas: ${erro.message}</p>`;
      }
    }

    function corrigirQuiz() {
      let acertos = 0;
      let total = gabarito.length;

      gabarito.forEach(p => {
        const selecao = document.querySelector(`input[name="questao${p.idQuestao}"]:checked`);
        const respostaJogador = selecao ? selecao.value : null;

        if (respostaJogador === p.alternativaCorreta) {
          acertos++;
        }
      });

      const resultadoDiv = document.getElementById('resultado-quiz');
      resultadoDiv.innerHTML = `
        <h2>Resultado</h2>
        <p>Você acertou ${acertos} de ${total} perguntas.</p>
        <p>Sua nota: ${((acertos / total * 10).toFixed(1))} / 10</p>
      `;
    }
  </script>
</body>
</html>