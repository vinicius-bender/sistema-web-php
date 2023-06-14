<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Styles-->
    <link type="text/css" rel="stylesheet" href="./styles/admin.css">
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

    <header>
        <div class="logo">
            <p id="espacamento">💪
            <p>
            <p>SuplementaFit</p>
            <p id="inverter">💪</p>
        </div>

        <div class="info">
            
            <div class="home">
                <i class="fa-solid fa-house" style="color: #ffffff;"></i>
                <a href="index.php">Home</a>
            </div>

            <div class="editar">
                <i class="fa-sharp fa-solid fa-pen" style="color: #ffffff;"></i>
                <a href="EditarProtudos.php">Editar</a>
            </div>

            <div class="cadastrar">
                <i class="fa-solid fa-floppy-disk" style="color: #ffffff;"></i>
                <a href="admin.php">Cadastrar</a>
            </div>


            <div class="account">
                <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                <?php if (isset($_SESSION['nome'])) {
                    echo strtoupper(substr($_SESSION['nome'], 0, 1));
                    echo ("<form action='admin.php' method='POST'>
                            <button class='sairBtn' type='submit' value='Sair' name='sair'>Sair</button>
                        </form>  
                    ");
                } else {
                    echo ("<a href='login.php'>Entrar</a>");
                } ?>
            </div>
        </div>
    </header>



    <form action="admin.php" method="POST" class="formCadastro" enctype="multipart/form-data">
        <input class="texto-preto" type="text" name="nomeProduto" placeholder="Nome do produto" required>
        <input class="texto-preto" type="number" name="valorProduto" placeholder="Valor do produto" required>
        <input id="imagem" type="file" name="imagemProduto" accept="image/*" required>
        <input id="submit" type="submit" name="cadastrar" value="Cadastrar">
    </form>



</body>

</html>


<?php


if (isset($_POST["cadastrar"])){

    $nome = $_POST["nomeProduto"];
    $valor = $_POST["valorProduto"];
    $imagem =  "./assets/images/" . $_FILES["imagemProduto"]["name"];
    move_uploaded_file($_FILES["imagemProduto"]["tmp_name"], $imagem);

     // Create connection
     $conn = mysqli_connect("localhost", "root", "", "loja");
     // Check connection
     if (!$conn) {
         die("Connection failed: " . mysqli_connect_error());
     }

    $sql = "INSERT INTO product (nome, valor, imagem)
    VALUES ('$nome', '$valor', '$imagem')";
    
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Produto cadastrado com sucesso!")</script>';
    } else {
        echo '<script>alert("Erro ao cadastrar produto!")</script>';
    }
    mysqli_close($conn);
}


if (isset($_POST['sair'])) {
    if (isset($_SESSION['nome'])) {
        $_COOKIE["login"] = false;
        setcookie("login", "", time() - 3600);
        unset($_SESSION['id']);
        unset($_SESSION['nome']);
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        unset($_SESSION['tipoUsuario']);
        header('Location: index.php');
    }
}
?>