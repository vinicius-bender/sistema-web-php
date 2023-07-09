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
    <link type="text/css" rel="stylesheet" href="./styles/navadmstyle.css">
    <link type="text/css" rel="stylesheet" href="./styles/admin.css">
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!--Icons-->
    <script src="https://kit.fontawesome.com/8a0ec70a6e.js" crossorigin="anonymous"></script>
</head>

<body>
      
    <?php 
        include_once("navadm.php");
    ?>

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
     $conn = mysqli_connect("localhost", "root", "rootadmin", "loja");
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
?>