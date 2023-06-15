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
    <?php 
    if (isset($_SESSION['nome']) && isset($_SESSION["tipoUsuario"]) === "adm"){
        echo ("
        <link type='text/css' rel='stylesheet' href='./styles/navadmstyle.css'>
        <link type='text/css' rel='stylesheet' href='./styles/admin.css'>");
    }else{
        echo ("
        <link type='text/css' rel='stylesheet' href='./styles/navuserstyle.css'>
        <link type='text/css' rel='stylesheet' href='./styles/index.css'>");
    }
        
    ?>
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
            include_once ("navadm.php");
        } 
        else {
            include_once ("navuser.php");
        }
    ?>
    
    <?php
   echo ("<h1>Produtos</h1>");

   echo ("<section>");
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
           <form action='index.php' method='POST'>
                   <div class='produto'>
                       <div class='bg-imagem'> ");
                       echo "<img id='imagem-produto' src='$imagem'>'";
                       echo ("</div>
                       <div class='info-produto'> 
                           <div class='infos'> 
                                <input class='info-input' type='hidden' name='idProd' value='$idProduto'>
                                <input class='info-input' type='hidden' name='nomeProduto' value='$nome'>
                                <input class='info-input' type='hidden' name='valorProduto' value='$valor'>
                                <p>$nome</p>
                                <p>R$$valor</p>
                           </div>
                           <input class='carrinho' type='submit' name='carrinho' value='Adicionar ao Carrinho'>
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

<?php

if (isset($_POST['carrinho'])){



}

if (isset($_POST['sair'])) {
        session_destroy();
        header('Location: index.php');
        exit;
}

?>