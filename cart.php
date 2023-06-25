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
        <link type='text/css' rel='stylesheet' href='./styles/cart.css'>");
    }else{
        echo ("
        <link type='text/css' rel='stylesheet' href='./styles/navuserstyle.css'>
        <link type='text/css' rel='stylesheet' href='./styles/cart.css'>");
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
        $temItem = false;
        // Create connection
        $conn = mysqli_connect("localhost", "root", "rootadmin", "loja");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT p.idproduct as pidproduct, p.nome as pnome, p.valor as pvalor, p.imagem as pimagem,
                c.quantity as cquantity, c.iduser as ciduser, c.idproduct as cidprodut,
                u.iduser as uiduser
                FROM product as p, cart as c, user as u
                WHERE c.iduser = u.iduser AND p.idproduct = c.idproduct";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                if ($_SESSION['id'] === $row["ciduser"]){
                    $temItem = true;
                    $idProduto = $row["pidproduct"];
                    $nome = $row["pnome"];
                    $valor = $row["pvalor"];
                    $imagem = $row["pimagem"];
                    $quantidade = $row["cquantity"];
                    echo ("
                    <form class='formClass' action='cart.php' method='POST'>
                            <div class='produto'>
                                <div class='bg-imagem'>");
                                echo "<img id='imagem-produto' src='$imagem'>'";
                                echo ("</div>
                                <div class='info-produto'> 
                                    <div class='infos'> 
                                        <input class='info-input' type='hidden' name='idProd' value='$idProduto'>
                                        <input class='info-input' type='hidden' name='nomeProduto' value='$nome'>
                                        <input class='info-input' type='hidden' name='valorProduto' value='$valor'>
                                        <input class='btn' type='submit' name='add' value='+'>
                                        <input class='btn' type='submit' name='sub' value='-'>
                                        <input disabled class='disabled-input' type='text' name='quant' value='$quantidade'>
                                        <p>$nome</p>
                                        <p>R$$valor</p>
                                    </div>
                                </div>
                            </div>
                    </form>
                    ");
                }
            }
        } else {
            $temItem = false;
        }
        mysqli_close($conn);
        if ($temItem){
            echo ("
                <form class='formBtnCompra'>
                <input class='FinalizaCompra' type='submit' name='finaliza' value='Finalizar Compra'>
                </form>
            ");
        }else{
            echo ("
                <p class='vazio'>Carrinho Vazio</p>
            ");
        }
    ?>
</body>
</html>


<?php 

// Create connection
$conn = mysqli_connect("localhost", "root", "rootadmin", "loja");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['add'])){

    $id = $_POST['idProd'];

    $quant = $quantidade + 1;

    $sql = "UPDATE cart SET quantity = $quant WHERE idproduct = '$id'";

    if ($conn->query($sql) === TRUE) {
        // echo "Record updated successfully";
      } else {
        echo "Error updating record: " . $conn->error;
      }
}

if (isset($_POST['sub'])){

    $id = $_POST['idProd'];

    $quant = $quantidade - 1;

    if ($quantidade > 0){
        $sql = "UPDATE cart SET quantity = $quant WHERE idproduct = '$id'";

        if ($conn->query($sql) === TRUE) {
            // echo "Record updated successfully";
          } else {
            echo "Error updating record: " . $conn->error;
          }
        
    }else{
        $sql = "DELETE FROM cart WHERE idproduct = '$id'";

        if (mysqli_query($conn, $sql)) {
        // echo "Record deleted successfully";
        } else {
        echo "Error deleting record: " . mysqli_error($conn);
        }
    }
}
mysqli_close($conn);
?>


