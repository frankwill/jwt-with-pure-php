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

    #payload,
    #token {
      resize: none;
      height: 120px;
    }
  </style>
</head>

<body class="d-flex align-items-center">

  <main class="w-100 m-auto">

    <div class="row pt-4 justify-content-center align-items-center">
      <div class="col-8">
        <div class="alert alert-primary" role="alert">
          <div class="d-flex align-items-center alert-heading">
            <span class="material-icons-outlined me-2">error_outline</span>
            <h4 class="alert-heading m-0">Palavra-chave</h4>
          </div>
          <p>A palavra-chave foi pré-definida no servidor como <code>my_secret_key</code>. Ao utilizar esta biblioteca, certifique-se de criar uma palavra-chave segura de sua escolha e, preferencialmente, armazene-a em <strong>variáveis de ambiente</strong>.</p>
        </div>
      </div>
    </div>

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
            <input type="text" class="form-control" id="secret" name="secret" placeholder="Defina uma palavra-chave segura" required value="my_secret_key">
          </div>
          <button type="submit" class="btn btn-primary">Criar Token</button>
        </form>
      </div>

      <div class="col-4 m-0">
        <div class="form-floating">
          <textarea id="payload" class="form-control text-secondary" readonly></textarea>
          <label for="payload">Payload</label>
        </div>
        <div class="form-floating">
          <textarea id="token" class="form-control text-secondary mt-3" readonly></textarea>
          <label for="token">Token</label>
        </div>
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
            <input type="text" class="form-control" id="token-validate" name="token" placeholder="Digite seu token" required>
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
    const showAlertValidateToken = document.getElementById("show-alert-validate-token")

    async function handleUrlSearch(fetchUrl, formElement) {
      const formData = new FormData(formElement)
      const response = await fetch(fetchUrl, {
        method: "POST",
        body: formData
      })
      return await response.json()
    }

    function handleSubmitForm(fetchUrl, formElement, alertElement) {
      formElement.addEventListener("submit", async (e) => {
        e.preventDefault()
        const { payload, token, msg } = await handleUrlSearch(fetchUrl, formElement)
        if (fetchUrl === "generateToken.php") {
          payloadTextArea.value = JSON.stringify(payload, null, 2)
          tokenTextArea.value = token
        }

        let dynamicBGAlert
        if(msg == "Token válido") {
          dynamicBGAlert = 'alert-success'
        } else {
          dynamicBGAlert = 'alert-warning'
        }

        if (fetchUrl === "validateToken.php") {
            const existingAlert = document.getElementById("show-alert-validate-token")
            const btnCloseAlert = document.getElementById("btn-close-alert")

            if (existingAlert) {
                existingAlert.querySelector('span').textContent = msg
                existingAlert.querySelector('.alert').className = `alert ${dynamicBGAlert} alert-dismissible fade show`;
            } else {
                const htmlAlert = `
                <div id="show-alert-validate-token" class="row pt-4 justify-content-center align-items-center">
                    <div class="col-12">
                        <div class="alert ${dynamicBGAlert} alert-dismissible fade show" role="alert">
                            <span>${msg}</span>
                            <button id="btn-close-alert" type="button" class="btn-close"></button>
                        </div>
                    </div>
                </div>`
                formValidateToken.insertAdjacentHTML("afterend", htmlAlert)

                document.getElementById("btn-close-alert").addEventListener("click", function() {
                    document.getElementById("show-alert-validate-token").remove()
                })
            }
        }

        if (alertElement) {
          alertElement.classList.replace("d-none", "d-flex")
        }
      })
    }

    function sendFormGenerateToken() {
      handleSubmitForm("generateToken.php", formPayload, showAlertGeneratedToken)
    }
    sendFormGenerateToken()

    function sendFormValidateToken() {
      handleSubmitForm("validateToken.php", formValidateToken, showAlertValidateToken)
    }
    sendFormValidateToken()
  </script>
</body>

</html>