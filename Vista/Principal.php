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

    unset($_SESSION['saldo']);

    unset($_SESSION['conf_cue']);
    unset($_SESSION['conf_cant']);
    unset($_SESSION['conf_cue_ben']);
    unset($_SESSION['conf_nom_ben']);


    if(!isset($_SESSION['llave_login']) || $_SESSION['llave_login'] != "activo"){

       
        header("Location: ../Vista/Login.php");
       
       

    }else{
        $_SESSION['llave_transaccion'] = "activo";
        $_SESSION['llave_con_estado'] = "activo";
    }

    

    

?>
    
    <script>

        function Redirigir(id){

            if(id === "btn_tra"){

                window.location.href = "../Vista/transaccion/transaccion.php";

            }

            if(id === "btn_est"){
                window.location.href = "../Vista/ConsultarEstado.php";
            }
            


        }


        window.addEventListener('pageshow',function(event){

            if(event.persisted){

                location.reload();
            }


        });


    </script>


        <img src="" alt="logo.png">

        <br>
        <br>

        <button onclick="Redirigir('btn_tra')" id="btn_tra">Transacción</button><br> <br><br>

        <button onclick="Redirigir('btn_est')" id="btn_est">Consultar Estado de Cuenta</button>

        

</body>
</html>