<?php
    session_start();

    if (!isset($_SESSION['nome'])) {
        header('Location: index.php');
        exit;
    }

    if (isset($_POST["editarProduto"])) {

        $id = $_POST["idProd"];
        $nome = $_POST["nomeProduto"];
        $valor = $_POST["valorProduto"];
    
    
        include("./db/conexao.php");
         
         if (!isset($_FILES["imagemProduto"])){
            $sql = "UPDATE product SET nome = '$nome',  valor = '$valor' WHERE idProduct = '$id'";
         }else{
            $imagem =  "./assets/images/" . $_FILES["imagemProduto"]["name"];
            move_uploaded_file($_FILES["imagemProduto"]["tmp_name"], $imagem);
            $sql = "UPDATE product SET nome = '$nome',  valor = '$valor',  imagem = '$imagem' WHERE idProduct = '$id'";
         }
        
        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Produto alterado com sucesso!")</script>';
        } else {
            echo '<script>alert("Erro ao alterar o produto!")</script>';
        }
        mysqli_close($conn);
    }

    if (isset($_POST["removerProduto"])) {

        $id = $_POST["idProd"];
    
        include("./db/conexao.php");
         
        
        $sql = "DELETE FROM product WHERE idproduct = $id";
    
        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Produto removido com sucesso!")</script>';
        } else {
            echo '<script>alert("Erro ao remover o produto!")</script>';
        }
        mysqli_close($conn);
    }

    
    
    if (isset($_POST['sair'])) {
            session_destroy();
            header('Location: index.php');
            exit;
    }
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Styles-->
    <link type="text/css" rel="stylesheet" href="./styles/navadmstyle.css">
    <link type="text/css" rel="stylesheet" href="./styles/editarProduto.css">
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

    include_once("navadm.php");


    echo ("<h2>Editar informações dos produtos</h2>");

    echo ("<section>");
    
    include("./db/conexao.php");

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
            <form action='editarProdutos.php' method='POST'>
                    <div class='produto'>
                        <div class='bg-imagem'> ");
                        echo "<img id='imagem-produto' src='$imagem'>'";
                        echo ("</div>
                        <div class='info-produto'> 
                            <input class='info-input' type='hidden' name='idProd' value='$idProduto'>
                            <div class='prod'>
                                <label for='nomeProduto'>Nome:</label><br>
                                <input class='info-input' type='text' name='nomeProduto' value='$nome'>
                            </div>
                            <div class='prod'>
                                <label for='valorProduto'>Valor(R$):</label><br>
                                <input class='info-input' type='number' name='valorProduto' value='$valor'>
                            </div>
                            <input id='edit-imagem' type='file' name='imagemProduto' accept='image/*'>
                            <input class='EditarProduto' type='submit' name='editarProduto' value='Editar produto'>
                            <input class='RemoverProduto' type='submit' name='removerProduto' value='Remover produto'>
                        </div>
                        
                    </div>
                
            </form>
            ");
        }
    } else {
        // echo "0 results";
    }
    mysqli_close($conn);
    echo ("</section>");
    ?>  

</body>
</html>

