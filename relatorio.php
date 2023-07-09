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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="./styles/navadmstyle.css">
    <link type='text/css' rel='stylesheet' href='./styles/relatorio.css'>
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
    ?>

    <table class='table'>
        <thead>
            <tr>
                <!-- <th scope='col'>ID Usuário</th> -->
                <th scope='col'>Produto</th>
                <th scope='col'>ID Produto</th>
                <th scope='col'>Valor Unid</th>
                <th scope='col'>Quantidade</th>
                <th scope='col'>Data</th>
            </tr>
        </thead>

        <?php
        // Create connection
        $conn = mysqli_connect("localhost", "root", "rootadmin", "loja");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT c.iduser as ciduser , p.idproduct as pidproduct, c.quantity as cquantity,
        c.estado as cestado, p.nome as pnome, p.valor as pvalor , s.iduser as siduser ,
        DATE_FORMAT(s.saleDate,'%d/%M/%Y %H:%m:%s') as ssaleDate
        FROM  user as u, cart as c, sale as s, product as p
        WHERE s.iduser = c.iduser = u.iduser AND c.idproduct = p.idproduct AND c.estado = 1 AND
        CAST(s.saleDate as date) between CAST(date_add(curdate(), INTERVAL -30 DAY) as date)  AND CAST(curdate() as date)
        ORDER BY c.iduser ASC";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $valorTotal = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $idUsuario = $row['siduser'];
                $idProduto = $row['pidproduct'];
                $nomeProduto = $row['pnome'];
                $valor = $row['pvalor'];
                $quantidade = $row['cquantity'];
                $valorTotal = $valorTotal + ($row['pvalor'] * $row['cquantity']);
                $data = $row['ssaleDate'];
                echo ("
                        <tbody>
                            <tr>
                                <td>$nomeProduto</td>
                                <td>$idProduto</td>
                                <td>$valor</td>
                                <td>$quantidade</td>
                                <td>$data</td>
                            </tr>
                        </tbody>
                ");
            }
        }
        mysqli_close($conn);
        echo ("<td>Valor total: R$ " . "<span>$valorTotal</span></td>");
        ?>
        </table>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>
</body>

</html>