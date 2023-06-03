<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--Styles-->
  <link type="text/css" rel="stylesheet" href="./styles/cadastro.css">
  <!--Fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
    rel="stylesheet">
  <!--Icons-->
  <script src="https://kit.fontawesome.com/8a0ec70a6e.js" crossorigin="anonymous"></script>
</head>

<body>

  <form action="cadastro.php" method="POST">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <input type="text" name="endereco" placeholder="Endereco (Rua e bairro)" required>
    <input type="text" name="cep" placeholder="CEP" required>
    <input type="text" name="cidade" placeholder="Cidade" required>
    <input type="text" name="estado" placeholder="Estado" required>
    <input id="submit" type="submit" name="cadastrar" value="Cadastrar">
  </form>

  <div id="login-existente">
    <p>Já possui uma conta? Faça o Login!</p>

    <div id="entrar">
      <a href="login.php">Entrar</a>
      <div>
    </div>
</div>
</body>

</html>

<?php

if (isset($_POST["cadastrar"])) {

  $nome = $_POST["nome"];
  $email = $_POST["email"];
  $senha = $_POST["senha"];
  $endereco = $_POST["endereco"];
  $cep = $_POST["cep"];
  $cidade = $_POST["cidade"];
  $estado = $_POST["estado"];
  $existe = false;

  $conn = mysqli_connect("localhost", "root", "", "loja");

  if (mysqli_connect_errno()){
    echo ("Deu ruim: " . mysqli_connect_error());
  }

  $sql = "SELECT email FROM user";
  $result = mysqli_query($conn, $sql);

  while ($row = mysqli_fetch_assoc($result)){
    if ($row['email'] === $email){
      $existe = true;
    }
  }
  if (!$existe){
    mysqli_query($conn, "INSERT INTO user (nome, email, senha, endereco, cep, cidade, estado)
    VALUES ('$nome', '$email', '$senha', '$endereco', '$cep', '$cidade', '$estado')");
    mysqli_close($conn);
    header('Location: login.php');
  }else{
    echo ("
    <div id='ja-existe'> 
      Este e-mail já está cadastrado!
    <div>
    ");
    mysqli_close($conn);
  }
}
?>