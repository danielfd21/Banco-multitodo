<?php 



//Base de datos

include "../../recursos/bd/bd.php";


$con = $conexion;

// Modelo cliente

include "../../Modelo/Cliente.php";


$cli = new Cliente();

session_start();













$id = "";
$cuenta_dep = "";

if(isset($_POST['txt_id_tran'])){
    
    $id = $_POST['txt_id_tran'];
    $cuenta_dep = $cli->Get_Numero_Cuenta_Transaccion($con,$id);
   
    
}else{
    echo 'no se recibio el id';
}




$fila = $cli->Consulta_Filtrar_Estado_Cuenta($con,$cuenta_dep,"transaccion.Id_tra",$id);
$saldo = $cli->Mostrar_Saldo($cuenta_dep, $con);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../recursos/estilos/Imprimir_comprobante.css">
    <title>Document</title>
</head>
<body>

<h1><label for="">RECIBO DE TRANSACCIÓN</label></h1>


<ul  id="lis_recibo_transaccion" style="border: 2px solid green; list-style: none;">
            



                <?php  foreach($fila as $imprimir ){ ?> 

                

                    
                

                
         
                <li><strong>Fecha:</strong> &nbsp;&nbsp;&nbsp;<?php echo $imprimir["fecha_tra"] ?> </li>
                 <li><strong>Hora:</strong> &nbsp;&nbsp;&nbsp; <?php echo $imprimir["Hora_tra"] ?></li>
                 <li><strong>Cantidad: </strong> &nbsp;&nbsp;&nbsp; <?php echo $imprimir["Cantidad"] ?>$</li>
                 <li><strong>Nombre del depositante:</strong> &nbsp;&nbsp;&nbsp; <?php echo $imprimir["Remitente"] ?></li>
                 <li><strong>Cuenta del depositante:</strong> &nbsp;&nbsp;&nbsp; <?php  echo $imprimir["Cuenta_rem"] ?></li>
                 <li><strong>Nombre del bneficiario:</strong> &nbsp;&nbsp;&nbsp; <?php echo $imprimir["Beneficiario"] ?></li> 
                 <li><strong>Cuenta del beneficiario:</strong> &nbsp;&nbsp;&nbsp; <?php echo  $imprimir["Cuenta_ben"] ?></td>
                 <li><strong>Saldo restante:</strong>&nbsp;&nbsp;&nbsp;<?php echo $saldo;?></li>
                    <?php  } ?>
                


                </ul>

                <button id="btn_imp_com" type="button" onclick="window.print()">IMPRIMIR</button>
        
</body>
</html>
