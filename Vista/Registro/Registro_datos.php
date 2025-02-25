<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../recursos/estilos/Registro_datos.css">
    <title>Document</title>
</head>
<body>

<?php 

session_start();




if(isset($_SESSION['mensaje2'])){

    echo '<div>'.$_SESSION['mensaje2'].'</div>';
    $_SESSION['mensaje2'] = null;
}


if(!isset($_SESSION['llave_continuar']) || $_SESSION['llave_continuar'] == "desactivo"){

    header("Location: ../Registro/Registro.php");

}


$_SESSION['llave_registrar'] = 'desactivo';


?>

<script>

window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        location.reload(); // Si la página viene del caché, recargar
    }
});

</script>


    
<h1>Datos de cliente</h1> <br>

<script src="../../recursos/js/Componentes.js"></script>


<form action="../../Controlador/ClienteControlador.php" method="post">

<label for="">Usuario:</label>
<input type="text"  name="txt_usu" oninput="Conf_Usu(document.getElementById('txt_u').value)" id="txt_u"> <br>


<ul id="list_req_usu">

    <li class="invalido" id="long"> de 8 a 16 digitos </li>
    <li class="invalido" id="mayus"> Una letra en mayuscula </li>
    <li class="invalido" id="minus"> Una letra en minuscula </li>
    <li class="invalido" id="nume"> Un numero </li>
    <li class="invalido" id="espa"> no usar espacios en blanco </li>
    

</ul>



<label for="">Contraseña:</label>
<input type="password" name="txt_cla" id="txt_cl" oninput="Conf_Cla(document.getElementById('txt_cl').value); Igu_Cla(document.getElementById('txt_cl').value,document.getElementById('txt_cl2').value)" > 
<button type="button" id="btn_mostrar" onclick="Mostrar(document.getElementById('txt_cl'),document.getElementById('btn_mostrar'))">Mostrar</button>
<br>


<ul id="list_req_usu">

    <li class="invalido" id="long_cl" > de 8 a 16 digitos </li>
    <li class="invalido" id="mayus_cl"> Una letra en mayuscula </li>
    <li class="invalido" id="minus_cl"> Una letra en minuscula </li>
    <li class="invalido" id="nume_cl"> Un numero </li>
    <li class="invalido" id="cara_cl"> Un caracter no alfanumerico </li>
    

</ul>



<label for="">Repetir Contraseña:</label>
<input type="password" name="txt_cla2" id="txt_cl2" oninput="Igu_Cla(document.getElementById('txt_cl').value,document.getElementById('txt_cl2').value)"> 
<button type="button" id="btn_mostrar2" onclick="Mostrar(document.getElementById('txt_cl2'),document.getElementById('btn_mostrar2'))">Mostrar</button>
<br>
<ul id="cla_req_igu">
    <li class="invalido" id="clav"> Claves iguales </li>
</ul> <br>


<input type="submit" name="btn_registrar" id="btn_reg" value="REGISTRAR">

</form>

</body>
</html>