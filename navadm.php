<?php 
echo ("
<header>
    <div class='logo'>
        <p id='espacamento'>💪
        <p>
        <p>SuplementaFit</p>
        <p id='inverter'>💪</p>
    </div>

    <div class='info'>
    
        <!-- <div class='home'>
            <i class='fa-solid fa-house' style='color: #ffffff;'></i>
            <a href='index.php'>Inicio</a>
        </div> -->

        <div class='editar'>
            <i class='fa-sharp fa-solid fa-pen' style='color: #ffffff;'></i>
            <a href='editarProdutos.php'>Editar</a>
        </div>

        <div class='cadastrar'>
            <i class='fa-solid fa-floppy-disk' style='color: #ffffff;'></i>
            <a href='admin.php'>Cadastrar</a>
        </div>

        <div class='relatorio'>
            <i class='fa-solid fa-file' style='color: #ffffff;'></i>
            <a href='relatorio.php'>Relatorio</a>
        </div>
    
        ");
    echo (" <div class='account'>
            <i class='fa-solid fa-user' style='color: #ffffff;'></i> ");
    if (isset($_SESSION['nome'])) {
        $Nome = $_SESSION['nome'];
        $primeiroNome = explode(" ", $Nome);
        echo ($primeiroNome[0]);
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
?>