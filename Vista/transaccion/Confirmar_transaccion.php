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

    include "../../recursos/bd/bd.php";
    include "../../Modelo/Cliente.php";

    $cli = new Cliente();

    $con = $conexion;

    if(!isset($_SESSION['llave_transaccion_confirmada']) ||$_SESSION['llave_transaccion_confirmada'] != "activo"){
       
        
        header("Location: ../../Vista/Login.php");
      
        
       
        
    }else{
        $_SESSION['llave_transaccion_confirmada'] = "desactivo";
        $_SESSION['llave_transaccion'] = "desactivo";
    }
    
    $_SESSION['llave_transaccion_exitosa'] = "desactivo";
    
    

    
    
    ?>

    <script>


    window.addEventListener('pageshow',function(event){

        if(event.persisted){

            location.reload();
        }

    });



    </script>


    <form action="../../Controlador/ClienteControlador.php" method="post">
    <h1>  Confirmar Transferencia Bancaria  </h1>


    <label for="">DESDE: </label> <br> <br>

    <ul style="list-style: none; border: solid 2px blue; width: 1000px;">

    <li> Cuenta:  <?php echo  $_SESSION['conf_cue'];   ?>     </li>
    <li> Saldo: <?php  echo $cli->Mostrar_Saldo($_SESSION['conf_cue'],$con);   ?>  </li>

    </ul>



    <br> <br>


    <label for="" style="display: flex; justify-content: center;"> Cantidad:  <?php  echo $_SESSION['conf_cant'];   ?> $ </label>


    <br> <br>

    <label for=""><strong>PARA: </strong></label> <br> <br>


    <ul style="list-style: none; border: solid 2px blue; width: 1000px;">

    <li> Cuenta:  <?php  echo $_SESSION['conf_cue_ben'];   ?>   </li>
    <li> Nombres:  <?php  echo $_SESSION['conf_nom_ben'];   ?>  </li>

    </ul>

    <br>
    <br>

    <input type="submit" name="btn_confirmar_transferencia" id="btn_con_tra" value="Confirmar Transferencia"> 

    </form>
</body>
</html>