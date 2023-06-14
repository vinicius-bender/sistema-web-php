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
    <link type="text/css" rel="stylesheet" href="./styles/index.css">
    <!-- <link type="text/css" rel="stylesheet" href="./styles/admin.css"> -->
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <!--Icons-->
    <script src="https://kit.fontawesome.com/8a0ec70a6e.js" crossorigin="anonymous"></script>
    <!--Design https://museshopcart.webflow.io/-->
    <title>SuplementaFit</title>
</head>

<body>
    <?php
        if (isset($_SESSION['nome']) && isset($_SESSION["tipoUsuario"]) === "adm") {
            echo ("
        <header>
            <div class='logo'>
                <p id='espacamento'>💪
                <p>
                <p>SuplementaFit</p>
                <p id='inverter'>💪</p>
            </div>

            <div class='info'>
            
                <div class='home'>
                    <i class='fa-solid fa-house' style='color: #ffffff;'></i>
                    <a href='index.php;'>Home</a>
                </div>

                <div class='editar'>
                    <i class='fa-sharp fa-solid fa-pen' style='color: #ffffff;'></i>
                    <a href='EditarProtudos.php'>Editar</a>
                </div>

                <div class='cadastrar'>
                    <i class='fa-solid fa-floppy-disk' style='color: #ffffff;'></i>
                    <a href='admin.php'>Cadastrar</a>
                </div>
            
                ");
            echo (" <div class='account'>
                    <i class='fa-solid fa-user' style='color: #ffffff;'></i> ");
            if (isset($_SESSION['nome'])) {
                echo strtoupper(substr($_SESSION['nome'], 0, 1));
                echo ("<form action='index.php' method='POST'>
                            <button class='sairBtn' type='submit' value='Sair' name='sair'>Sair</button>
                        </form>  
                ");
            } else {
                echo ("<a href='login.php'>Entrar</a>");
            }
                echo ("</div>");
            echo ("</div>");
            echo ("</header>");
        } 
        else {
            echo ("
            <header>
                <div id='phone'>
                    <i class='fa-solid fa-phone' style='color: #ffffff;'></i>
                    <p>+55 (55) 123456789</p>
                </div>


        <div class='logo'>
            <p id='espacamento'>💪
            <p>
            <p>SuplementaFit</p>
            <p id='inverter'>💪</p>
        </div>
            ");
            echo (
                "<div class='info'>
                    <div class='cart'>
                        <i class='fa-solid fa-cart-shopping' style='color: #ffffff;'></i>
                        <p>Carrinho</p>
                </div>
            ");
            echo (" <div class='account'>
                                <i class='fa-solid fa-user' style='color: #ffffff;'></i> ");
            if (isset($_SESSION['nome'])) {
                echo strtoupper(substr($_SESSION['nome'], 0, 1));
                echo ("<form action='admin.php' method='POST'>
                         <button class='sairBtn' type='submit' value='Sair' name='sair'>Sair</button>
                        </form>  
                    ");
            } else {
                echo ("<a href='login.php'>Entrar</a>");
            }
            echo ("</div>");
            echo ("</div>");
        echo("</header>");
        }
    ?>

    <form action='index.php' method='POST'>
        <h1>Produtos</h1>
        <div class='produtos'>
    
    <?php
    // Create connection
    $conn = mysqli_connect("localhost", "root", "", "loja");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT idproduct, nome, valor, imagem FROM product";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $idProduto = $row["idproduct"];
            $nome = $row["nome"];
            $valor = $row["valor"];
            $imagem = $row["imagem"];
            echo ("
            
                    <div class='produto' id='$idProduto'>
                        <div class='bg-imagem'> ");
                        echo "<img src='$imagem'>'";
                        echo ("</div>
                        <div class='info-produto'> 
                            <p>$nome</p>
                            <p>R$$valor</p>
                        </div>
                        <input class='addCarrinho' type='submit' name='addCarrinho' value='Adicionar ao carrinho'>
                    </div>
            ");
        }
    } else {
        // echo "0 results";
    }

    mysqli_close($conn);

    ?>
        
    </div>
    <form>

</body>

</html>

<?php

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