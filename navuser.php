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
    echo ("<form action='index.php' method='POST'>
             <button class='sairBtn' type='submit' value='Sair' name='sair'>Sair</button>
            </form>  
        ");
} else {
    echo ("<a href='login.php'>Entrar</a>");
}
echo ("</div>");
echo ("</div>");
echo("</header>");
?>