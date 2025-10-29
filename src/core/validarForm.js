function validarFormulario() {
  let campos = document.querySelectorAll("input[required]");
  let valido = true;

  campos.forEach(campo => {
    if (!campo.value.trim()) {
      campo.classList.add("campoInvalido");
      valido = false;
    } else {
      campo.classList.remove("campoInvalido");
    }
  });

  const senha = document.getElementById("senha");
  const confirmar = document.getElementById("confirmar");
  if (senha.value !== confirmar.value) {
    senha.classList.add("campoInvalido");
    confirmar.classList.add("campoInvalido");
    valido = false;
  }

  return valido;
}