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

if(!isset($_SESSION['llave_registrar']) || $_SESSION['llave_registrar'] != "activo"){


    header("Location: ../Registro/Registro.php");
   

}else{
    $_SESSION['llave_continuar'] = 'desactivo';
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



<h1>Cliente registrado con exito</h1>
    
</body>
</html>