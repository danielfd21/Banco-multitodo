<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    // hola aqui en transaccion exitosa añadi este mensaje para que git lo vea 
    
    session_start();

     if(!isset($_SESSION['llave_transaccion_exitosa']) || $_SESSION['llave_transaccion_exitosa'] != "activo"){

        header("Location: ../../Vista/Login.php");
     }
   
     
     unset($_SESSION['conf_cue']);
     unset($_SESSION['conf_cant']);
     unset($_SESSION['conf_cue_ben']);
     unset($_SESSION['conf_nom_ben']);



    
    ?>


    <script>


     window.addEventListener('pageshow',function(event){


        if(event.persisted){

            location.reload();


        }

        
     });

        


     


    </script>

<h1> TRANSACCION REALIZADA CON EXITO</h1>


<br> <br>

<label for="">Imprimir comprobante</label> <br> <br>


<input type="submit" name="btn_imprimir" id="btn_imp" value="IMPRIMIR">


<a href="../../Vista/Login.php"></a>

</body>
</html>