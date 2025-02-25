<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1> Trasnferencia Bancaria  </h1> <br><br>

    <?php 
    
    session_start();
    

    include "../../recursos/bd/bd.php"; 
    include "../../Modelo/Cliente.php";

    $con = $conexion;
    $cli = new Cliente();


    if(isset($_SESSION['mensaje_transferir'])){

        echo $_SESSION['mensaje_transferir'];
        $_SESSION['mensaje_transferir'] = null;
    }



    if(!isset($_SESSION['llave_transaccion']) || $_SESSION['llave_transaccion'] != "activo"){

        header("Location: ../../Vista/Login.php");
       
        
    }
    
    
    
   
 


    ?>


    <script>


    window.addEventListener('pageshow',function(event){

        if(event.persisted){

            location.reload();

        }


    });


    </script>



    <form action="../../Controlador/ClienteControlador.php" method="post">

    <ul id="lista_datos"   style="list-style:  none; border: solid 2px blue; width: 1000px;">

    <li> Cedula:  <?php  echo $cli->Mostrar_Datos_Transaccion("Cedula",$con);  ?> &nbsp&nbsp&nbsp   Nombre: <?php  echo $cli->Mostrar_Datos_Transaccion("Nombres",$con);    ?>  &nbsp&nbsp&nbsp   Apellidos: <?php  echo $cli->Mostrar_Datos_Transaccion("Apellidos",$con);    ?>  &nbsp&nbsp&nbsp   Correo: <?php  echo $cli->Mostrar_Datos_Transaccion("Correo",$con);    ?></li>
    <li> Cuenta: <select name="cb_cuenta" id=""><?php  foreach($cli->Mostrar_Cuenta($con) as $cuenta){ echo '  <option value="'.$cuenta.'"> '.$cuenta.'</option>';  }    ?> </select></li>

    </ul>

    <br>
    <br>

    <input type="submit" name="btn_continuar_tra" id="btn_con_tra" value="Continuar" style="display: flex; margin: auto;">

    <?php 
    
    if(isset($_SESSION['saldo'])){

    
    
    
    ?>

    <ul id="lista_monto" style="list-style: none; border: solid 2px blue; width: 1000px;">

    <li>  Saldo: <?php  echo $_SESSION['saldo']; ?>  </li>

    <li> Numero de cuenta del beneficiario: <input type="number" name="txt_cuenta_beneficiario" id="txt_ben"> </li> 
    
    <li>Nombre del beneficiario:<input type="text" name="txt_nombre_beneficiario" id="txt_nom"> </li> 
    <li> Cantidad a depositar: <input type="number" name="txt_cantidad_deposito" id="txt_cant_dep">  </li>

    </ul>

        <br>


    <input type="submit" name="btn_transferir" id="btn_tra" value="Continuar">

    <?php 
    
    }

    ?>

    </form>


   


</body>
</html>