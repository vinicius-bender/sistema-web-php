<?php 
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

if (isset($_SESSION['nome'])) {
    echo (
        "<div class='info'>
            <div class='home'>
                <i class='fa-solid fa-house' style='color: #ffffff;'></i>
                <a href='index.php'>Inicio</a>
            </div>
                <div class='cart'>
                    <i class='fa-solid fa-cart-shopping' style='color: #ffffff;'></i>
                    <a href='cart.php'>Carrinho</a>
            </div>
    ");
}

echo (" <div class='account'>
                    <a > <i class='fa-solid fa-user' style='color: #ffffff;'></i> </a> ");
if (isset($_SESSION['nome'])) {
    $Nome = $_SESSION['nome'];
    $primeiroNome = explode(" ", $Nome);
    echo ($primeiroNome[0]);
    echo ("<form action='index.php' method='POST'>
             <button class='sairBtn' type='submit' value='Sair' name='sair'>Sair</button>
            </form>  
        ");
} else {
    echo ("<a class='loginBtn' href='login.php'>Entrar</a>");
}
echo ("</div>");
echo ("</div>");
echo("</header>");
?>