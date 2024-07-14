<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JWT com PHP Puro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/material-icons@1.13.12/iconfont/material-icons.min.css" rel="stylesheet">
  <style>
    html,
    body {
      height: 100%;
    }

    textarea {
      resize: none;
    }
  </style>
</head>

<body class="d-flex align-items-center">

  <main class="w-100 m-auto">
    <div class="row justify-content-center align-items-center">
      <div class="col-4 m-0">
        <form id="form-generate-token" method="POST">
          <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome" required>
          </div>
          <div class="mb-3">
            <label for="company" class="form-label">Empresa</label>
            <input type="text" class="form-control" id="company" name="company" placeholder="Digite o nome da sua empresa">
          </div>
          <div class="mb-3">
            <label for="secret" class="form-label">Palavra-chave</label>
            <input type="password" class="form-control" id="secret" name="secret" placeholder="Coloque uma palavra-chave bem segura" required>
          </div>
          <button type="submit" class="btn btn-primary">Criar Token</button>
        </form>
      </div>

      <div class="col-4 m-0">
        <textarea id="payload" class="form-control text-secondary" rows="4" readonly></textarea>
        <textarea id="token" class="form-control text-secondary mt-3" rows="4" readonly></textarea>
      </div>
    </div>

    <div id="show-alert-generate-token" class="row pt-4 justify-content-center align-items-center d-none">
      <div class="col-8">
        <div class="alert alert-success" role="alert">
          <h4 class="alert-heading">Token gerado!</h4>
          <p>
            Seu token foi gerado com sucesso, você pode visualizar mais detalhes nos cards acima ou no site do próprio JWT em <a href="https://jwt.io/" target="_blank">jwt.io</a>.
          </p>
          <hr>
          <div class="d-flex align-items-center mb-0">
            <span class="material-icons-outlined pe-1">error_outline</span>
            <strong>O token é válido por 60 minutos.</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-3 justify-content-center align-items-center">
      <div class="col-8 m-0">
        <form id="form-validate-token" method="POST">
          <div class="mb-4">
            <label for="token" class="form-label">Token</label>
            <input type="text" class="form-control" id="token" name="token" placeholder="Digite seu token" required>
          </div>
          <button type="submit" class="btn btn-primary">Validar Token</button>
        </form>
      </div>

    </div>
  </main>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <script>
    const formPayload = document.getElementById("form-generate-token")
    const formValidateToken = document.getElementById("form-validate-token")
    const payloadTextArea = document.getElementById("payload")
    const tokenTextArea = document.getElementById("token")
    const showAlertGeneratedToken = document.getElementById("show-alert-generate-token")

    async function handleUrlSearch(fetchUrl, formElement) {
      const formData = new FormData(formElement)
      const response = await fetch(fetchUrl, {
        method: "POST",
        body: formData
      })
      return await response.json()
    }

    function handleSubmitForm(fetchUrl, formElement, alertElement) {
      formElement.addEventListener("submit", async(e) => {
        e.preventDefault()  
        const { payload, token } = await handleUrlSearch(fetchUrl, formElement)  
        payloadTextArea.value = JSON.stringify(payload, null, 2)
        tokenTextArea.value = token
        alertElement.classList.replace("d-none", "d-flex")
      })
    }

    function sendFormGenerateToken() {
      handleSubmitForm("generateToken.php", formPayload, showAlertGeneratedToken) 
    }
    sendFormGenerateToken()

    function sendFormValidateToken() {
      handleSubmitForm("validateToken.php", formValidateToken)
    }
    sendFormValidateToken()



  </script>
</body>

</html>