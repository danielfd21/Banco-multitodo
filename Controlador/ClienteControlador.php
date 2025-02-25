<?php 


session_start();

// base de datos

include "../recursos/bd/bd.php";

$con = $conexion;


// modelo 

include "../Modelo/Cliente.php";

$cli = new Cliente();

// vista






if(isset($_POST['btn_continuar'])){

    $ced = $_POST['txt_ced'];
    $cla = $_POST['txt_cla'];

    $mensaje = $cli->Verificar_Datos($ced,$cla,$con);

    $_SESSION['mensaje'] = $mensaje;

    

    $_SESSION['cedula'] = $ced;

    

    


}


if(isset($_POST['btn_registrar'])){

    $usu = $_POST['txt_usu'];
    $cla = $_POST['txt_cla'];
    $cla2 = $_POST['txt_cla2'];

    $ced = "";

    $ced = $_SESSION['cedula'];

    $mensaje = $cli->Crear_Usaurio($usu,$cla,$cla2,$ced,$con);

    $_SESSION['mensaje2'] = $mensaje;


}


if(isset($_POST['btn_logear'])){

    $usu = $_POST['txt_usu'];
    $cla = $_POST['txt_cla'];

    $mensaje = $cli->Logear($usu,$cla,$con);

    $_SESSION['mensaje_log'] = $mensaje; 

}


if(isset($_POST['btn_continuar_tra'])){


    $cuenta = $_POST['cb_cuenta'];

    header("Location: ../../Vista/transaccion/transaccion.php");
    $_SESSION['saldo'] =  $cli->Mostrar_Saldo($cuenta,$con);


}


if(isset($_POST['btn_transferir'])){
    $cue = $_POST['cb_cuenta'];
    $cue_ben = $_POST['txt_cuenta_beneficiario'];
    $cue_nom = $_POST['txt_nombre_beneficiario'];
    $cant = $_POST['txt_cantidad_deposito'];


$mensaje = $cli->Calcular_Transaccion($cue,$cue_ben,$cue_nom,$cant,$con);

$_SESSION['mensaje_transferir'] = $mensaje;


}


if(isset($_POST['btn_confirmar_transferencia'])){

    $mensaje = $cli->Confirmar_Transferencia($con);

    $_SESSION['mensaje_confirmacion'] = $mensaje;



}













?>

