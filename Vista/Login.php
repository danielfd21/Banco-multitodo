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

if(isset($_SESSION['mensaje_log'])){

    echo '<div>'.$_SESSION['mensaje_log'].'</div>';
    $_SESSION['mensaje_log'] = null;


}


unset($_SESSION['saldo']);

    
unset($_SESSION['conf_cue']);
unset($_SESSION['conf_cant']);
unset($_SESSION['conf_cue_ben']);
unset($_SESSION['conf_nom_ben']);


$_SESSION['llave_login'] = "desactivo";


?>

<script>

window.addEventListener('pageshow',function(event){

if(event.persisted){

    location.reload();
}


});


</script>



<script src="../recursos/js/Componentes.js"></script>



        <form action="../Controlador/ClienteControlador.php" method="post">
        <h1> INICIO DE CESIÓN BANCO MULTITODO </h1> <br>
        <img src="" alt="logo.php"> <br>

        <label for="">USUARIO:</label> <br>
        <input type="text" name="txt_usu" id="txt_us"> <br>

        <label for="">Contraseña:</label> <br>
        <input type="password" name="txt_cla" id="txt_cl"> <button type="button" id="btn_mostrar" onclick="Mostrar(document.getElementById('txt_cl'),document.getElementById('btn_mostrar'))">Mostrar</button> <br>

        <br>

        <input type="submit" name="btn_logear" id="btn_log"> 

        <br>
        <br>

        ¿No te has registrado aun? <a href="../Vista/Registro/Registro.php">regitrate aquí</a> 


        </form>



</body>
</html>