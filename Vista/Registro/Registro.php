<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php 
session_start();

if(isset($_SESSION['mensaje'])){

    echo '<div>'.$_SESSION['mensaje'].'</div>';
    $_SESSION['mensaje'] = null;

}


$_SESSION['llave_continuar'] = 'desactivo';



?>

<script>

window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        location.reload(); // Si la página viene del caché, recargar
    }
});



unset($_SESSION['saldo']);

    
unset($_SESSION['conf_cue']);
unset($_SESSION['conf_cant']);
unset($_SESSION['conf_cue_ben']);
unset($_SESSION['conf_nom_ben']);

</script>

    <script src="../../recursos/js/Componentes.js"></script>


    <form action="../../Controlador/ClienteControlador.php" method="post">

        <h1> Registro DE USUARIO BANCO MULTITODO </h1> <br>

        <img src="" alt="logo.png"> <br>

        <label for="">Cedula:</label> <br>
        <input type="number"  name="txt_ced" id="txt_ce" oninput="Desbloquear(document.getElementById('cb_te_co'),document.getElementById('txt_ce').value,document.getElementById('txt_cl').value,document.getElementById('btn_con'))" required > <br>

        <label for="">Clave de tarjeta de debito</label>  <br>

        <input type="password"   name="txt_cla" id="txt_cl" onchange="Desbloquear(document.getElementById('cb_te_co'),document.getElementById('txt_ce').value,document.getElementById('txt_cl').value,document.getElementById('btn_con'))" readonly > <br> <br>

        <button type="button" id="btn_1"  value="1" onclick="SetClave(document.getElementById('btn_1').value,document.getElementById('txt_cl'),document.getElementById('btn_con'),document.getElementById('cb_te_co'),getElementById('txt_ce').value)">1</button>
        <button type="button" id="btn_2" value="2" onclick="SetClave(document.getElementById('btn_2').value,document.getElementById('txt_cl'),document.getElementById('btn_con'),document.getElementById('cb_te_co'),getElementById('txt_ce').value)">2</button>
        <button type="button" id="btn_3" value="3" onclick="SetClave(document.getElementById('btn_3').value,document.getElementById('txt_cl'),document.getElementById('btn_con'),document.getElementById('cb_te_co'),getElementById('txt_ce').value)">3</button>
        <br>
        <button type="button" id="btn_4" value="4" onclick="SetClave(document.getElementById('btn_4').value,document.getElementById('txt_cl'),document.getElementById('btn_con'),document.getElementById('cb_te_co'),getElementById('txt_ce').value)">4</button>
        <button type="button" id="btn_5" value="5" onclick="SetClave(document.getElementById('btn_5').value,document.getElementById('txt_cl'),document.getElementById('btn_con'),document.getElementById('cb_te_co'),getElementById('txt_ce').value)">5</button>
        <button type="button" id="btn_6" value="6" onclick="SetClave(document.getElementById('btn_6').value,document.getElementById('txt_cl'),document.getElementById('btn_con'),document.getElementById('cb_te_co'),getElementById('txt_ce').value)">6</button>
        <br>
        <button type="button" id="btn_7" value="7" onclick="SetClave(document.getElementById('btn_7').value,document.getElementById('txt_cl'),document.getElementById('btn_con'),document.getElementById('cb_te_co'),getElementById('txt_ce').value)">7</button>
        <button type="button" id="btn_8" value="8" onclick="SetClave(document.getElementById('btn_8').value,document.getElementById('txt_cl'),document.getElementById('btn_con'),document.getElementById('cb_te_co'),getElementById('txt_ce').value)">8</button>
        <button type="button" id="btn_9" value="9" onclick="SetClave(document.getElementById('btn_9').value,document.getElementById('txt_cl'),document.getElementById('btn_con'),document.getElementById('cb_te_co'),getElementById('txt_ce').value)">9</button>
        <br>
        <button type="button" id="btn_0" value="0" onclick="SetClave(document.getElementById('btn_0').value,document.getElementById('txt_cl'),document.getElementById('btn_con'),document.getElementById('cb_te_co'),getElementById('txt_ce').value)">0</button>
        <button type="button" id="btn_bo" onclick="BorrarClave(document.getElementById('txt_cl'),document.getElementById('btn_con'))">Borrar</button> <br><br>



        Aceptar terminos y condiciones <input type="checkbox" name="cb_ter_con" id="cb_te_co" onchange="Desbloquear(document.getElementById('cb_te_co'),document.getElementById('txt_ce').value,document.getElementById('txt_cl').value,document.getElementById('btn_con'))"> <br><br>




        <input type="submit" name="btn_continuar" id="btn_con" value="continuar" disabled="false"> <br><br>

        <a href="../../Vista/Login.php">Volver a inicio de cesión</a>

    </form>

    
</body>
</html>