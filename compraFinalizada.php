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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
    <!-- Modal -->
    <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Obrigado pela confiaça!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Compra Efetuada com sucesso!
            </div>
            <div class="modal-footer">
                <a href="index.php">Voltar ao Início</a>
            </div>
            </div>
        </div>
    </div>

    <?php
        if (isset($_SESSION['nome']) && isset($_SESSION["tipoUsuario"]) === "adm") {
            include_once ("navadm.php");
        }else {
            include_once ("navuser.php");
        }
    ?>
    
    <?php 
        $temItem = false;
        
        include("./db/conexao.php");

        $sql = "SELECT p.idproduct as pidproduct, p.nome as pnome, p.valor as pvalor, p.imagem as pimagem,
        c.idcart as cidcart, c.quantity as cquantity, c.iduser as ciduser, c.idproduct as cidprodut,
        c.estado as cestado, u.iduser as uiduser
        FROM product as p, cart as c, user as u
        WHERE c.iduser = u.iduser AND p.idproduct = c.idproduct";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                if ($_SESSION['id'] === $row["ciduser"]){
                    $idUser = $row["ciduser"];
                    $idProduto = $row["pidproduct"];
                    $nome = $row["pnome"];
                    $valor = $row["pvalor"];
                    $imagem = $row["pimagem"];
                    $quantidade = $row["cquantity"];
                    $cartId = $row["cidcart"];
                    $estado = $row["cestado"];
                    if ($estado == '0'){
                        $temItem = true;
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
            }
        } else {
            $temItem = false;
        }
        if ($temItem){
            echo ("
                <form action='cart.php' class='formBtnCompra' method='POST'>
                    <input class='info-input' type='hidden' name='idUsuario' value='$idUser'>
                    <input class='info-input' type='hidden' name='idCart' value='$cartId'>
                    <input class='FinalizaCompra' type='submit' name='finaliza' value='Finalizar Compra'>
                </form>
            ");
        }else{
            echo ("
                <p class='vazio'>Carrinho Vazio</p>
            ");
        }
        mysqli_close($conn);
    ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script>
    $('#modalExemplo').modal('show');
</script>
</body>
</html>

<?php 

?>

