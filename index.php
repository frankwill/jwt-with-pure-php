<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JWT com PHP Puro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/material-icons@1.13.12/iconfont/material-icons.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
    }
  </style>
</head>

<body class="d-flex align-items-center">

  <main class="w-100 m-auto">
    <div class="row justify-content-center align-items-end">
      <div class="col-6 p-0">
        <form id="generate-token" action="generateToken.php" method="POST">
          <span class="d-block display-6">Gerar Token</span>
          <div class="input-group my-1">
            <input id="username" type="text" class="form-control" placeholder="Digite oque quer armazenar no token. Ex: usuário" aria-label="Digite o seu usuário" aria-describedby="button-addon2">
            <button class="btn btn-primary" type="button" id="button-addon2">Gerar</button>
          </div>      
          <input class="form-control" type="text" value="Copie seu token que será gerado aqui" disabled readonly>
        </form>
      </div>
    </div>
  
    <div class="row justify-content-center align-items-end pt-4">
      <div class="col-6 p-0">
        <form id="generate-token" action="validateToken.php" method="POST">
          <span class="d-block display-6">Validar Token</span>
          <div class="input-group mb-3">
            <input id="username" type="text" class="form-control" placeholder="Digite o token para validar" aria-label="Digite o seu usuário" aria-describedby="button-addon2">
            <button class="btn btn-primary" type="button" id="button-addon2">Validar</button>
          </div>      
        </form>
      </div>
      
      <div class="row p-0 justify-content-center align-items-end">
        <div class="col-6 alert alert-success" role="alert">
          <div class="d-flex align-items-center">
            <span class="me-2 fs-5 material-icons-outlined">check_circle</span>
            <span class="fs-5">Token válido!</span>
          </div>
          <span>Este token é válido por 60 minutos.</span>
          <input class="form-control" type="text" value="Copie seu token que será gerado aqui" disabled readonly>
        </div>
      </div>

    </div>
  </main>
  


  <?php if (!empty($result)) { ?>
    <p>Token: <?= $result ?></p>
  <?php } ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <script>
    const formPayload = document.getElementById("generate-token")
    const btnGenerateToken = document.getElementById("btn-generate-token")

    btnGenerateToken.addEventListener("click", (e) => {
      e.preventDefault()
      console.log("click")
    })
  </script>
</body>

</html>