<?php
    session_start();
?>

<?php 

include("./db/conexao.php");

if (isset($_POST['add'])){

    $id = $_POST['idProd'];
    $idCart = $_POST['idCart'];
    $quant = $_POST['quant'] + 1;


    $sql = "UPDATE cart SET quantity = $quant WHERE idproduct = '$id' AND idcart = ' $idCart'";

    if (mysqli_query($conn, $sql)) {
        // echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
    }
}

if (isset($_POST['sub'])){

    $id = $_POST['idProd'];
    $idCart = $_POST['idCart'];
    $quant = $_POST['quant'] - 1;

    if ($quant > 0){
        $sql = "UPDATE cart SET quantity = $quant WHERE idproduct = '$id' AND idcart = ' $idCart'";

        if (mysqli_query($conn, $sql)) {
            // echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
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


if (isset($_POST['finaliza'])){

    date_default_timezone_set('America/Sao_Paulo');
    $cartid = $_POST['idCart'];
    $idUser = $_POST['idUsuario'];
    $saleDate = date("Y-m-d, H:i:s");

    $sql = "INSERT INTO sale (saleDate, idcart, iduser)
    VALUES ('$saleDate', '$cartid', '$idUser')";

    if (!mysqli_query($conn, $sql)) {
        echo '<script>alert("Erro ao finalizar compra!")</script>';
    }else{
        
        $sql = "UPDATE cart SET estado = '1' WHERE iduser = '$idUser'";
        
        if (!mysqli_query($conn, $sql)) {
            echo '<script>alert("Erro ao realizar compra compra!")</script>';
        }
    }

    header("Location: compraFinalizada.php");
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Styles-->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
    <link type='text/css' rel='stylesheet' href='./styles/cart.css'>
    <?php
    if (isset($_SESSION['nome']) && isset($_SESSION["tipoUsuario"]) === "adm"){
        echo ("
        <link type='text/css' rel='stylesheet' href='./styles/navadmstyle.css'>");
    }else{
        echo ("
        <link type='text/css' rel='stylesheet' href='./styles/navuserstyle.css'>");
    }
    ?>
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!--Icons-->
    <script src="https://kit.fontawesome.com/8a0ec70a6e.js" crossorigin="anonymous"></script>
    <!--Design https://museshopcart.webflow.io/-->
    <title>SuplementaFit</title>
</head>

<body>
    <?php
        if (isset($_SESSION['nome']) && isset($_SESSION["tipoUsuario"]) === "adm") {
            include_once ("navadm.php");
        }else {
            include_once ("navuser.php");
        }
    ?>
    
    <?php 
        $temItem = false;
        $valorTotal = 0;
        include("./db/conexao.php");

        $sql = "SELECT p.idproduct as pidproduct, p.nome as pnome, p.valor as pvalor, p.imagem as pimagem,
                c.idcart as cidcart, c.quantity as cquantity, c.iduser as ciduser, c.idproduct as cidprodut,
                c.estado as cestado, u.iduser as uiduser
                FROM product as p, cart as c, user as u
                WHERE c.iduser = u.iduser AND p.idproduct = c.idproduct";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($_SESSION['id'] === $row["ciduser"]){
                    $idUser = $row["ciduser"];
                    $idProduto = $row["pidproduct"];
                    $nome = $row["pnome"];
                    $valor = $row["pvalor"] * $row["cquantity"];
                    $imagem = $row["pimagem"];
                    $quantidade = $row["cquantity"];
                    $cartId = $row["cidcart"];
                    $estado = $row["cestado"];
                    if ($estado === '0'){
                        $temItem = true;
                        $valorTotal = $valorTotal + $valor;
                        echo ("
                        <form class='formClass' action='cart.php' method='POST'>
                            <div class='produto'>
                                <div class='info-produto'> 
                                        <div class='infos'> 
                                        <div class='bg-imagem'>");
                                            echo "<img id='imagem-produto' src='$imagem'>'";
                                        echo ("</div>
                                        <input class='info-input' type='hidden' name='idCart' value='$cartId'>
                                        <input class='info-input' type='hidden' name='idProd' value='$idProduto'>
                                        <input class='info-input' type='hidden' name='nomeProduto' value='$nome'>
                                        <input class='info-input' type='hidden' name='valorProduto' value='$valor'>
                                        <div class='btn-carrinho'>
                                            <input class='btn' type='submit' name='add' value='+'>
                                            <input class='btn' type='submit' name='sub' value='-'>
                                            <input class='disabled-input' type='text' name='quant' value='$quantidade'>
                                        </div>
                                        <div class='informacoes-produto'>
                                            <p>$nome</p>
                                            <p class='verde'>R$$valor</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    ");
                    }
                }
            }
        }else{
            $temItem = false;
        }
        if ($temItem){
            echo ("
                <form action='cart.php' class='formBtnCompra' method='POST'>
                    <input class='info-input' type='hidden' name='idUsuario' value='$idUser'>
                    <input class='info-input' type='hidden' name='idCart' value='$cartId'>
                    <input class='FinalizaCompra' type='submit' name='finaliza' value='Finalizar Compra'>
                </form>
                <p id='valorTotal'>Valor total da compra: <span class='verde'> R$$valorTotal </span></p>
            ");
        }else{
            echo ("
                <p class='vazio'>Carrinho Vazio</p>
            ");
        }
        mysqli_close($conn);
    ?>
</body>
</html>
