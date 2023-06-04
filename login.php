<?php

if (isset($_COOKIE['login'])) {
    header('Location: index.php');
} else {

    setcookie("login", "");
    if (isset($_POST['entrar'])) {

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $conn = mysqli_connect("localhost", "root", "", "loja");

        if (mysqli_connect_errno()) {
            echo ("Deu ruim: " . mysqli_connect_error());
        }

        $sql = "SELECT idUser, nome, senha, email FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['email'] === $email && $row['senha'] === $senha) {
                    session_start();
                    $_COOKIE["login"] = true;
                    $_SESSION['id'] = $row['idUser'];
                    $_SESSION['nome'] = $row['nome'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['senha'] = $row['senha'];
                    mysqli_close($conn);
                    header('Location: index.php');
                }else{
                    $_COOKIE["login"] = false;
                }
            }
            if ($_COOKIE["login"] === false){
                echo ("<div id='erroLogin'>Email ou senha errados!</div>");
            }
        }else {
            echo ("<div id='erroLogin'>Usuário não existe!</div>");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Styles-->
    <link type="text/css" rel="stylesheet" href="./styles/login.css">
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

    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input id="submit" type="submit" name="entrar" value="Entrar">
    </form>

    <div id="login-inexistente">
        <p>Não possui uma conta? Cadastre-se gratuitamente!</p>

        <div id="cadastrar">
            <a href="cadastro.php">Cadastrar-se</a>
            <div>
        </div>
</body>

</html>