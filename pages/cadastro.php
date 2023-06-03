<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Styles-->
    <link type="text/css" rel="stylesheet" href="../styles/cadastro.css">
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"rel="stylesheet">
    <!--Icons-->
    <script src="https://kit.fontawesome.com/8a0ec70a6e.js" crossorigin="anonymous"></script>
</head>

<body>

    <form action="/pages/cadastro.php" method="POST"> 
        <input type="text" name="nome" placeholder="Nome">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="senha" placeholder="Senha">
        <input type="text" name="endereco" placeholder="Endereco (Rua e bairro)">
        <input type="text" name="cep" placeholder="CEP">
        <input type="text" name="cidade" placeholder="Cidade">
        <input type="text" name="estado" placeholder="Estado">
        <input id="submit" type="submit" name="cadastrar" value="Cadastrar">
    </form>

    <div id="login-existente"> 
        <p>Já possui uma conta? Faça o Login!</p>
        
        <div id="entrar">
            <a href="./login.php">Entrar</a>
        <div>
    </div>
</body>

</html>