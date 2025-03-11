<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php

    session_start();

  // base de datos

    include "../recursos/bd/bd.php";

    $con = $conexion;

  // instancia cliente:

  include "../Modelo/Cliente.php";

  $cli = new Cliente();



  if(!isset($_SESSION['llave_con_estado']) || $_SESSION['llave_con_estado'] != 'activo'){


    header("Location: ../Vista/Login.php");
  }

?>


<body>

        
        
    
        <h1>  <label for=""> ESTADO DE CUENTA </label> </h1>

        <ul style="list-style: none; border: 2px solid red; width: 60%;">

        

        <li> Cedula: <?php echo $cli->Mostrar_Datos_Transaccion("Cedula",$con) ?> &nbsp;&nbsp;&nbsp;  Nombres:  <?php echo $cli->Mostrar_Datos_Transaccion("Nombres",$con)   ?> &nbsp;&nbsp;&nbsp;  Apellidos: <?php echo $cli->Mostrar_Datos_Transaccion("Apellidos",$con)  ?> &nbsp;&nbsp;&nbsp; Correo: <?php echo $cli->Mostrar_Datos_Transaccion("Correo",$con) ?> </li>
        <li> Cuenta: <select  onchange="MostrarEstado()" name="cb_cue_est" id="cb_cu_es"> <option value="Seleccione_est" id="opt_sel_est">--SELECCIONE--</option> <?php  foreach($cli->Mostrar_Cuenta($con) as $cuenta){ echo '<option value="'.$cuenta.'">'.$cuenta.'</option>'; }   ?>  </select>    </li>

        </ul>

        

        <div id="contenedor_tab_est">


        </div>

        <script src="../recursos/js/ConsultarEstadoajax.js">


        </script>
      

      



</body>
</html>