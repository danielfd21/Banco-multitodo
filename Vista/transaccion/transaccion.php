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
    <li> Cuenta: <select name="cb_cuenta"  onchange="Mostrar_datos_transaccion()" id="cb_cuen">   <option value="Seleccione" id="opt_sel">SELECCIONE</option> <?php  foreach($cli->Mostrar_Cuenta($con) as $cuenta){ echo '  <option value="'.$cuenta.'"> '.$cuenta.'</option>';  }    ?> </select> <label for="" id="lb_saldo"></label> </li>

    </ul>

    <br>
    <br>

   

   

    <br>

    '
    <ul  style="list-style: none; border: solid 2px blue; width: 1000px;">

                 
                 <li> Numero de cuenta del beneficiario: <input type="number" name="txt_cuenta_beneficiario" id="txt_ben"> </li> 
                 <li>Nombre del beneficiario:<input type="text" name="txt_nombre_beneficiario" id="txt_nom"> </li>
                <li> Cantidad a depositar: <input type="number" name="txt_cantidad_deposito" id="txt_cant_dep" step="any">  </li>
    
   
    </ul>';


        <br>


    <input type="submit" name="btn_transferir" id="btn_tra" value="Continuar">

    





   
   
   </form>

   <script src="../../recursos/js/Transaccion_ajax.js">



</script>


</body>
</html>