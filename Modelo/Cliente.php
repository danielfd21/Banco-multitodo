<?php 




class Cliente{

    







 //// Verificar UNO

    public function Verificar_Uno_Cliente($campo, $objeto,$con){


        $ok = false;

        
        $verificado = $con->prepare("SELECT * FROM Cliente WHERE {$campo} = ?");
        $verificado->bind_param('s',$objeto);
        $verificado->execute();
        $obtener_verificado = $verificado->get_result();
        if($obtener_verificado->num_rows > 0){

            $ok = true;

        }


        return $ok;





    }


    public function Verificar_Uno_Cuenta_Web($campo,$objeto,$con){

        $ok = false;

        $verificar = $con->prepare("SELECT * FROM cuenta_web WHERE {$campo} = ?");
        $verificar->bind_param('s',$objeto);
        $verificar->execute();
        $verificado = $verificar->get_result();
        if($verificado->num_rows > 0){

            $ok = true;

        }

        return $ok;

    }


    public function Verificar_Uno_Cuenta($campo,$objeto,$con){

        $ok = false;

        $consultar = $con->prepare("SELECT * FROM Cuenta WHERE {$campo} = ? ");
        $consultar->bind_param('s',$objeto);
        $consultar->execute();
        $consultado = $consultar->get_result();
        if($consultado->num_rows > 0){

            
            $ok = true;
           

        }


        return $ok;

    }



    public function Verificar_Datos($ced,$cla,$con){

        if($ced == null || $cla == null){

            header('Location: ../Vista/Registro/Registro.php');
            return "Por favor llene todos los campos";

        }else{


            $verificar_cue = $this->Verificar_Uno_Cuenta_Web("Cedula",$ced,$con);

            if($verificar_cue == false){


                $verificar_ced = $this->Verificar_Uno_Cliente("Cedula",$ced,$con);

                if($verificar_ced == true){
    
                    $get_clave = $con->prepare("SELECT * FROM Cuenta WHERE Cedula = ? AND Clave = ?");
                    $get_clave->bind_param('ss',$ced,$cla);
                    $get_clave->execute();
                    $clave_obtenida = $get_clave->get_result();
                    if($clave_obtenida->num_rows > 0){
                        
                        $estado_llave = "activo";

                        $_SESSION['llave_continuar'] = $estado_llave;
    
    
                        header('Location: ../Vista/Registro/Registro_datos.php');
    
                    }else{
                        
                        header('Location: ../Vista/Registro/Registro.php');
                        return "La clave es incorrecta";
                    }
    
    
    
    
                }else{
                    
                header('Location: ../Vista/Registro/Registro.php');
                    return "La cedula no se encuentra registrada";
                }
                
            }else{

                header('Location: ../Vista/Registro/Registro.php');
                return "El usuario ya tiene una cuenta banco multitodo registrada, en caso de perder los datos comuniquese con servicio al cliente";
            }


          



        }


    }


    public function Crear_Usaurio($usu, $cla, $cla2,$ced,$con){

        if($usu == null || $cla == null || $cla2 == null){
            header("Location: ../Vista/Registro/Registro_datos.php");
            return "Por favor llene todos los campos";


        }else{

                if($cla == $cla2){


                    $min = "/[a-z]/";
                    $may = "/[A-Z]/";
                    $num = "/[0-9]/";
                    $esp = "/\s/";

                    if(preg_match($min,$usu) && preg_match($may,$usu) && preg_match($num,$usu) && !preg_match($esp,$usu) && strlen($usu) >=8 && strlen($usu) <= 16 ){


                        $min = "/[a-z]/";
                        $may = "/[A-Z]/";
                        $num = "/[0-9]/";
                        $car = "/[@#_-]/";
    
                        if(preg_match($min,$cla) && preg_match($may,$cla) && preg_match($num,$cla) && preg_match($car,$cla) && strlen($cla) >= 8 && strlen($cla) <= 16 ){
    
                            
                            $verificar_usu = $this->Verificar_Uno_Cuenta_Web("Usuario",$usu,$con);

                            if($verificar_usu == false){



                                $cla_has =  password_hash($cla,PASSWORD_BCRYPT);

                                $est = "Activo";
                                $insertar = $con->prepare("INSERT INTO cuenta_web(`estado`, `Usuario`, `Clave`, `Cedula`,`Intentos`) VALUES(?,?,?,?,0)");

                                if($insertar == false){
                                    header("Location: ../Vista/Registro/Registro_datos.php");
                                    return "problema en la consulta".$con->error;

                                }

                                $insertar->bind_param('ssss',$est,$usu,$cla_has,$ced);
                                $insertar->execute();
                                


                                if($insertar->affected_rows > 0){

                                    $estado_llave = "activo";

                                    $_SESSION['llave_registrar'] = $estado_llave;

                                    header("Location: ../Vista/Registro/Cliente_Registrado.php");

                                }else{
                                    header("Location: ../Vista/Registro/Registro_datos.php");
                                    return "Lo sentimos ha ocurrido un error";
                                }
                                
                            }else{
                                header("Location: ../Vista/Registro/Registro_datos.php");
                                return "EL nombre de usuario ya se encuentra en uso";


                            }

    
    
    
                        }else{
                            header("Location: ../Vista/Registro/Registro_datos.php");
                            return "La contraseña debe contener como minimo entre 8 a 16 digitos con una letra en minuscula, una letra en mayuscula, un numero y un caracter no alfanumerico";
    
                        }





                    }else{
                        header("Location: ../Vista/Registro/Registro_datos.php");
                        return "El nombre de usuario debe contener como minimo entre 8 a 16 digitos con una letra en minuscula, una letra en mayuscula, un numero y sin espacios";

                    }





                   


                }else{
                    header("Location: ../Vista/Registro/Registro_datos.php");
                    return "Las claves son distintas";

                }


        }


    }



    // get objetos

   
    
    public function Get_Objeto_Cuenta_Web($objeto,$campo,$usuario,$con){


        $obtener_cl = $con->prepare("SELECT {$objeto} FROM Cuenta_Web WHERE {$campo} = ?");
        $obtener_cl->bind_param('s',$usuario);
        $obtener_cl->execute();
        $obtenido_cl = $obtener_cl->get_result();

        if($obtenido_cl->num_rows > 0){

            $obt = $obtenido_cl->fetch_assoc();
            return $obt[$objeto];

            

        }else{
            return null;
        }

    }

    public function Get_Cedula_Transaccion($con){

        $ced = "";

        $usu = $_SESSION['Usuario'];

        $obtener = $con->prepare("SELECT cliente.Cedula FROM cliente  INNER JOIN cuenta_web ON cliente.Cedula = cuenta_web.Cedula  WHERE Usuario = ?");
        $obtener->bind_param('s',$usu);
        $obtener->execute();
        $obtenido = $obtener->get_result();
        if($obtenido->num_rows > 0){

            $fila = $obtenido->fetch_assoc();
            $ced = $fila['Cedula'];

        }

        return $ced;

    }


    public function Actualizar_intentos($int,$usu,$con){

        $actualizar_int = $con->prepare("UPDATE cuenta_web SET Intentos = ? WHERE Usuario = ?");
        $actualizar_int->bind_param('ss',$int,$usu);
        $actualizar_int->execute();
        

    }




    public function Logear($usu,$cla,$con){

            if(!isset($_SESSION['intentos_log'] )){
                $_SESSION['intentos_log'] = 0;
            }

            
            $clave = "";

        if($usu == null || $cla == null){
            header("Location: ../../Vista/Login.php");
            return "Por favor llene todos los campos";

        }else{

            $ver_usu = $this->Verificar_Uno_Cuenta_Web("Usuario",$usu,$con);
            if($ver_usu == true){

               
                $clave = $this->Get_Objeto_Cuenta_Web("Clave","Usuario",$usu,$con);

                $estado = $this->Get_Objeto_Cuenta_Web("Estado","Usuario",$usu,$con);

                if(password_verify($cla,$clave) && $estado == "Activo"){

                    $_SESSION['intentos_log'] = 0;

                    $this->Actualizar_intentos($_SESSION['intentos_log'],$usu,$con);

                    $_SESSION['Usuario'] = $usu;
                    
                    $_SESSION['llave_login'] = "activo";
                    header("Location: ../../Vista/Principal.php");

                }else{

                    if($_SESSION['intentos_log'] >= 3){

                        
                        $est = "Desactivo";
                       


                        $actualizar_est = $con->prepare("UPDATE cuenta_web SET Estado = ? WHERE Usuario = ?");
                        $actualizar_est->bind_param('ss',$est,$usu);
                        $actualizar_est->execute();

                       
                    }else{

                        $_SESSION['intentos_log'] ++;

                        $this->Actualizar_intentos($_SESSION['intentos_log'],$usu,$con);

                    }


                   

                    header("Location: ../../Vista/Login.php");

                    if($estado == "Desactivo"){
                        return "La cuenta de la banca virtual se encuentra bloqueada, por favor comuniquese con el asistente virtual para desbloquearla";
                    }else{
                        return "La contraseña es incorrecta";
                    }
                    

                }


            }else{


                header("Location: ../../Vista/Login.php");
                return "El usuario es incorrecto";
            }


            

        }


    }

    
    

    public function Mostrar_Datos_Transaccion($obj,$con){



        $ced = $this->Get_Cedula_Transaccion($con);

        $mostrar_datos = $con->prepare("SELECT cliente.Cedula,  cliente.Nombres, cliente.Apellidos, cliente.Correo FROM CLiente WHERE Cedula = ? ");
        $mostrar_datos->bind_param('s',$ced);
        $mostrar_datos->execute();
        $mostrado = $mostrar_datos->get_result();

        if($mostrado->num_rows > 0){

            $fila = $mostrado->fetch_assoc();
            
            return $fila[$obj];
        }


    }


    public function Mostrar_Cuenta($con){

        $ced = $this->Get_Cedula_Transaccion($con);

        $obtener_cuenta = $con->prepare("SELECT Numero_cuenta FROM Cuenta  INNER JOIN cliente ON Cuenta.Cedula = cliente.Cedula  WHERE cliente.Cedula = ?");
        $obtener_cuenta->bind_param('s',$ced);
        $obtener_cuenta->execute();
        $obtenido = $obtener_cuenta->get_result();

        $cuentas = [];



        while($fila = $obtenido->fetch_assoc()){

           
            $cuentas[] = $fila['Numero_cuenta'];


        }

        return $cuentas;

    }

    public function Mostrar_Saldo($cue,$con){

        $obtener_saldo = $con->prepare("SELECT Saldo FROM Cuenta WHERE Numero_cuenta = ?");
        $obtener_saldo->bind_param('s',$cue);
        $obtener_saldo->execute();
        $saldo_obtenido = $obtener_saldo->get_result();

        if($saldo_obtenido->num_rows > 0){

            $fila = $saldo_obtenido->fetch_assoc();
            
            return $fila["Saldo"];

        }



    
    }
    


    public function Calcular_Transaccion($cue,$cue_ben,$nom_ben,$cant,$con){


        if($cue_ben == null || $nom_ben == null){
            header("Location: ../../Vista/transaccion/transaccion.php");
            return "por favor ingrese los datos del beneficiario";

        }else{


            if($cue != $cue_ben){

            

            $ver_cue_ben = $this->Verificar_Uno_Cuenta("Numero_cuenta",$cue_ben,$con);

            if($ver_cue_ben == true){


               $consultar_dat = $con->prepare("SELECT * FROM Cuenta  INNER JOIN Cliente ON Cuenta.Cedula = Cliente.Cedula WHERE  Cliente.Nombres = ? AND Numero_cuenta = ?"); 
               $consultar_dat->bind_param('ss',$nom_ben,$cue_ben);
               $consultar_dat->execute();
               $consultado_nom = $consultar_dat->get_result();
               if($consultado_nom->num_rows > 0){

                $saldo = $this->Mostrar_saldo($cue,$con);

                if( $cant <=  $saldo){

                     $_SESSION['llave_transaccion_confirmada'] = "activo";

                    $_SESSION['conf_cue'] = $cue;
                    $_SESSION['conf_cue_ben'] = $cue_ben;
                    $_SESSION['conf_nom_ben'] = $nom_ben;
                    $_SESSION['conf_cant'] = $cant;

                    header("Location: ../Vista/transaccion/Confirmar_transaccion.php");


                }else{
                    header("Location: ../Vista/transaccion/transaccion.php");
                    return "La cantidad solicitada supera el monto total de su saldo actual";
                }


                   


               }else{
                header("Location: ../Vista/transaccion/transaccion.php");
                    return "Los datos del beneficiario son erroneos";
               }

            }else{
                header("Location: ../Vista/transaccion/transaccion.php");
                return "La cuenta ingresada no existe";
            }

        }else{
            header("Location: ../Vista/transaccion/transaccion.php");
            return "La cuenta ingresada pertenece al usuario, no se permite esta transacción";
        }
            

        }


    }


    public function Confirmar_Transferencia($con){

        if(isset($_SESSION['conf_cue']) && isset($_SESSION['conf_cue_ben']) && isset($_SESSION['conf_nom_ben']) && isset($_SESSION['conf_cant']) ){
            date_default_timezone_set('America/New_York');
            $fecha_act = date('Y-m-d');
            $hora_act = date('H:i:s');

            $insertar = $con->prepare("INSERT INTO transaccion VALUES('',?,?,?,?,?)");
            $insertar->bind_param('sssss',$fecha_act,$hora_act,$_SESSION['conf_cant'],$_SESSION['conf_cue'],$_SESSION['conf_cue_ben']);
            $insertar->execute();
            $id_tra = $con->insert_id;

            $_SESSION['id_tra'] = $id_tra;

            if($insertar->affected_rows > 0){

                $restar_saldo = $con->prepare("CALL Transferir(?,?,?)");
                $restar_saldo->bind_param('sss',$_SESSION['conf_cue'],$_SESSION['conf_cue_ben'],$_SESSION['conf_cant']);
                $restar_saldo->execute();
                $restar_saldo->store_result();
                if($restar_saldo->affected_rows){

                    $_SESSION['llave_transaccion_exitosa'] = "activo";
                    header("Location: ../Vista/transaccion/Transaccion_exitosa.php");

                }


              

            }else{
                header("Location: ../Vista/transaccion/Confirmar_transaccion.php");
                return "Lo sentimos ha ocurrido un error";
            }

            
        }

        



    }

    public function Post_Mostrar_datos_transaccion($cone){

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            if(isset($_POST['cuenta'])){

                $cuenta = $_POST['cuenta'];

                $saldo = $this->Mostrar_Saldo($cuenta, $cone);

                echo "Saldo: ".$saldo."$";

               
              

            }

        }

    }

   


    public function Consulta_Estado_Cuenta($con,$cuenta){



        $consultar = $con->prepare("SELECT transaccion.Id_tra ,transaccion.fecha_tra, transaccion.Hora_tra, transaccion.Cantidad ,  cli_rem.Nombres  AS 'Remitente'  , transaccion.Cuenta_rem, cli_ben.Nombres AS 'Beneficiario'  , transaccion.Cuenta_ben FROM transaccion  INNER JOIN cuenta as cu_rem ON transaccion.Cuenta_rem = cu_rem.Numero_cuenta INNER JOIN cliente as cli_rem ON cu_rem.Cedula = cli_rem.Cedula  INNER JOIN cuenta AS cu_ben ON transaccion.Cuenta_ben = cu_ben.Numero_cuenta INNER JOIN cliente AS cli_ben ON cu_ben.Cedula = cli_ben.Cedula WHERE cu_rem.Numero_Cuenta = ? ORDER BY transaccion.Id_tra");
        $consultar->bind_param('s',$cuenta);
        $consultar->execute();
        $consultado = $consultar->get_result();
        

        $fila = [];

        while($columnas = $consultado->fetch_assoc()){

            

            $fila[] = $columnas;

           
        }

        return $fila;

    }

    public function Consulta_Estado_Cuenta_Recibidas($con,$cuenta){



        $consultar = $con->prepare("SELECT transaccion.Id_tra ,transaccion.fecha_tra, transaccion.Hora_tra, transaccion.Cantidad ,  cli_rem.Nombres  AS 'Remitente'  , transaccion.Cuenta_rem, cli_ben.Nombres AS 'Beneficiario'  , transaccion.Cuenta_ben FROM transaccion  INNER JOIN cuenta as cu_rem ON transaccion.Cuenta_rem = cu_rem.Numero_cuenta INNER JOIN cliente as cli_rem ON cu_rem.Cedula = cli_rem.Cedula  INNER JOIN cuenta AS cu_ben ON transaccion.Cuenta_ben = cu_ben.Numero_cuenta INNER JOIN cliente AS cli_ben ON cu_ben.Cedula = cli_ben.Cedula WHERE cu_ben.Numero_Cuenta = ? ORDER BY transaccion.Id_tra");
        $consultar->bind_param('s',$cuenta);
        $consultar->execute();
        $consultado = $consultar->get_result();
        

        $fila = [];

        while($columnas = $consultado->fetch_assoc()){

            

            $fila[] = $columnas;

           
        }

        return $fila;

    }




    public function Post_Mostrar_Estado_Cuenta($con){
        

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            if(isset($_POST['cuenta_est'])){

                $cuenta = $_POST['cuenta_est'];
                 $fila = $this->Consulta_Estado_Cuenta($con,$cuenta);
                 $fila_rec = $this->Consulta_Estado_Cuenta_Recibidas($con,$cuenta);
                 $saldo = $this->Mostrar_Saldo($cuenta,$con);
                


                echo '  <div id= "saldo_contendor"  style="display: flex; justify-content: center;"><h2> <label for="">Saldo: &nbsp;&nbsp; '.$saldo.' </label></h2> </div>';

                echo '<br><br><br>';

                echo '<h1><label for="">Movimientos Bancarios</label></h1>';

                echo '<h2><label for=""> Transferencias realizadas </label></h2>';

                echo '<br><br><br>';


                echo '<label for=""> Filtro por fecha:  </label> <input type="date" name="txt_fec" id="tx_fe" onchange="Filtrar_Fecha()"> <label for="">o Filtro por mes:</label> <input id="inp_mes_est"  type="month" onchange="Filtrar_Mes()">';

                

                echo '<br><br><br>';

                echo '<div id="contenedor-filtro">';

                echo '<table id="tb_estado" border = "2">
                <tr>

                <td> Fecha </td>
                <td> Hora </td>
                <td> Cantidad </td>
                <td> Nombre del depositante </td>
                <td> Cuenta del depositante </td>
                <td> Nombre del beneficiario </td>
                <td> Cuenta del beneficiario </td>
                <td> Descargar Comprobante </td>



                </tr>

                '; foreach($fila as $imprimir ){

                    
                echo '

                <tr> 
         
                <td>'.$imprimir["fecha_tra"].'</td>
                 <td>'.$imprimir["Hora_tra"].'</td>
                 <td>'.$imprimir["Cantidad"].'$ </td>
                 <td>'.$imprimir["Remitente"].'</td>
                 <td>'.$imprimir["Cuenta_rem"].'</td>
                 <td>'.$imprimir["Beneficiario"].'</td> 
                 <td>'.$imprimir["Cuenta_ben"].'</td>
                  <td><form action="../recursos/PDF/Plantillas/Recibo_transacción.php" METHOD="POST"><input type="hidden" name="txt_id_tran" id="txt_id_tra" value="'.htmlspecialchars($imprimir["Id_tra"]).'"><input type="submit" name="btn_mostrar_pdf" value="DESCARGAR PDF"></form></td>
                </tr>


                '; }

                


                echo '</table>';

                echo '<br><br><br>';
                

                echo '<h2><label for=""> Transferencias Recibidas  </label></h2>';

                echo '<table id="tb_estado_rec" border = "2">
                <tr>

                <td> Fecha </td>
                <td> Hora </td>
                <td> Cantidad </td>
                <td> Nombre del depositante </td>
                <td> Cuenta del depositante </td>
                <td> Nombre del beneficiario </td>
                <td> Cuenta del beneficiario </td>
                



                </tr>

                '; foreach($fila_rec as $imprimir ){

                    
                echo '

                <tr> 
         
                <td>'.$imprimir["fecha_tra"].'</td>
                 <td>'.$imprimir["Hora_tra"].'</td>
                 <td>'.$imprimir["Cantidad"].'$ </td>
                 <td>'.$imprimir["Remitente"].'</td>
                 <td>'.$imprimir["Cuenta_rem"].'</td>
                 <td>'.$imprimir["Beneficiario"].'</td> 
                 <td>'.$imprimir["Cuenta_ben"].'</td>
                  
                </tr>


                '; }


                echo '</table>';
        
                

                echo '</div>';


                


            }
           
            


        }

    }

    public function Consulta_Filtrar_Estado_Cuenta($con,$cuenta,$campo,$objeto,){

        $consulta = $con->prepare("SELECT transaccion.Id_tra, transaccion.fecha_tra, transaccion.Hora_tra, transaccion.Cantidad ,  cli_rem.Nombres  AS 'Remitente'  , transaccion.Cuenta_rem, cli_ben.Nombres AS 'Beneficiario'  , transaccion.Cuenta_ben FROM transaccion  INNER JOIN cuenta as cu_rem ON transaccion.Cuenta_rem = cu_rem.Numero_cuenta INNER JOIN cliente as cli_rem ON cu_rem.Cedula = cli_rem.Cedula  INNER JOIN cuenta AS cu_ben ON transaccion.Cuenta_ben = cu_ben.Numero_cuenta INNER JOIN cliente AS cli_ben ON cu_ben.Cedula = cli_ben.Cedula WHERE cu_rem.Numero_Cuenta = ? AND {$campo} = ? ORDER BY transaccion.Id_tra");
        $consulta->bind_param('ss',$cuenta,$objeto);
        $consulta->execute();
        $consultado = $consulta->get_result();

        $filas = [];

        while($columnas = $consultado->fetch_assoc()){

            $filas[] = $columnas;

        }

        return $filas;

    }

    public function Consulta_Filtrar_Estado_Cuenta_Recibo($con,$cuenta,$campo,$objeto,){

        $consulta = $con->prepare("SELECT transaccion.Id_tra, transaccion.fecha_tra, transaccion.Hora_tra, transaccion.Cantidad ,  cli_rem.Nombres  AS 'Remitente'  , transaccion.Cuenta_rem, cli_ben.Nombres AS 'Beneficiario'  , transaccion.Cuenta_ben FROM transaccion  INNER JOIN cuenta as cu_rem ON transaccion.Cuenta_rem = cu_rem.Numero_cuenta INNER JOIN cliente as cli_rem ON cu_rem.Cedula = cli_rem.Cedula  INNER JOIN cuenta AS cu_ben ON transaccion.Cuenta_ben = cu_ben.Numero_cuenta INNER JOIN cliente AS cli_ben ON cu_ben.Cedula = cli_ben.Cedula WHERE cu_ben.Numero_Cuenta = ? AND {$campo} = ? ORDER BY transaccion.Id_tra");
        $consulta->bind_param('ss',$cuenta,$objeto);
        $consulta->execute();
        $consultado = $consulta->get_result();

        $filas = [];

        while($columnas = $consultado->fetch_assoc()){

            $filas[] = $columnas;

        }

        return $filas;

    }



    public function Post_Filtrar_Estado_Cuenta_Fecha($con){

        

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(isset($_POST['fecha']) && isset($_POST['cuentaestado'])){

                $fecha = $_POST['fecha'];
                $cuenta = $_POST['cuentaestado'];

               

               

                $fila = $this->Consulta_Filtrar_Estado_Cuenta($con,$cuenta,"transaccion.fecha_tra",$fecha);
                $fila_rec = $this->Consulta_Filtrar_Estado_Cuenta_Recibo($con,$cuenta,"transaccion.fecha_tra",$fecha);

                if($fila != null){

               

                    echo '<table id="tb_estado" border = "2">
                    <tr>
    
                    <td> Fecha </td>
                    <td> Hora </td>
                    <td> Cantidad </td>
                    <td> Nombre del depositante </td>
                    <td> Cuenta del depositante </td>
                    <td> Nombre del beneficiario </td>
                    <td> Cuenta del beneficiario </td>
                    <td> Descargar Comprobante </td>
    
    
    
                    </tr>
    
                    '; foreach($fila as $imprimir ){
    
                        
                    echo '
    
                    <tr> 
             
                    <td>'.$imprimir["fecha_tra"].'</td>
                     <td>'.$imprimir["Hora_tra"].'</td>
                     <td>'.$imprimir["Cantidad"].'$ </td>
                     <td>'.$imprimir["Remitente"].'</td>
                     <td>'.$imprimir["Cuenta_rem"].'</td>
                     <td>'.$imprimir["Beneficiario"].'</td> 
                     <td>'.$imprimir["Cuenta_ben"].'</td>
                      <td><form action="../recursos/PDF/Plantillas/Recibo_transacción.php" METHOD="POST"><input type="hidden" name="txt_id_tran" id="txt_id_tra" value="'.htmlspecialchars($imprimir["Id_tra"]).'"><input type="submit" name="btn_mostrar_pdf" value="DESCARGAR PDF"></form></td>
                    </tr>
    
    
                    '; }
    
                    
                    
    
                    echo '</table>';
    
                    echo '<br><br><br>';
                    
                }

                    if($fila_rec != null){
    
                    echo '<h2><label for=""> Transferencias Recibidas  </label></h2>';
                        
                    
                    echo '<table id="tb_estado_rec" border = "2">
                    <tr>
    
                    <td> Fecha </td>
                    <td> Hora </td>
                    <td> Cantidad </td>
                    <td> Nombre del depositante </td>
                    <td> Cuenta del depositante </td>
                    <td> Nombre del beneficiario </td>
                    <td> Cuenta del beneficiario </td>
                    
    
    
    
                    </tr>
    
                    '; foreach($fila_rec as $imprimir ){
    
                        
                    echo '
    
                    <tr> 
             
                    <td>'.$imprimir["fecha_tra"].'</td>
                     <td>'.$imprimir["Hora_tra"].'</td>
                     <td>'.$imprimir["Cantidad"].'$ </td>
                     <td>'.$imprimir["Remitente"].'</td>
                     <td>'.$imprimir["Cuenta_rem"].'</td>
                     <td>'.$imprimir["Beneficiario"].'</td> 
                     <td>'.$imprimir["Cuenta_ben"].'</td>
                      
                    </tr>
    
    
                    '; }
    
    
                    echo '</table>';
                        
                }
                    
                

                    if($fila_rec == null && $fila == null){

                   
                    echo ' <button type="button" onclick="MostrarEstado()">Volver a mostrar Todas las transacciónes </button>';
                    }



            }

        }


    }

    public function Consulta_Filtrar_Estado_Cuenta_Dos_Campos($con,$cuenta,$campo1,$campo2,$objeto1,$objeto2){

        $consulta = $con->prepare("SELECT transaccion.Id_tra, transaccion.fecha_tra, transaccion.Hora_tra, transaccion.Cantidad ,  cli_rem.Nombres  AS 'Remitente'  , transaccion.Cuenta_rem, cli_ben.Nombres AS 'Beneficiario'  , transaccion.Cuenta_ben FROM transaccion  INNER JOIN cuenta as cu_rem ON transaccion.Cuenta_rem = cu_rem.Numero_cuenta INNER JOIN cliente as cli_rem ON cu_rem.Cedula = cli_rem.Cedula  INNER JOIN cuenta AS cu_ben ON transaccion.Cuenta_ben = cu_ben.Numero_cuenta INNER JOIN cliente AS cli_ben ON cu_ben.Cedula = cli_ben.Cedula WHERE cu_rem.Numero_Cuenta = ? AND {$campo1} = ? AND {$campo2} = ? ORDER BY transaccion.Id_tra" );
        $consulta->bind_param('sss',$cuenta,$objeto1,$objeto2);
        $consulta->execute();
        $consultado = $consulta->get_result();

        $filas = [];

        while($columnas = $consultado->fetch_assoc()){

            $filas[] = $columnas;

        }

        return $filas;

    }

    public function Consulta_Filtrar_Estado_Cuenta_Dos_Campos_Recibo($con,$cuenta,$campo1,$campo2,$objeto1,$objeto2){

        $consulta = $con->prepare("SELECT transaccion.Id_tra, transaccion.fecha_tra, transaccion.Hora_tra, transaccion.Cantidad ,  cli_rem.Nombres  AS 'Remitente'  , transaccion.Cuenta_rem, cli_ben.Nombres AS 'Beneficiario'  , transaccion.Cuenta_ben FROM transaccion  INNER JOIN cuenta as cu_rem ON transaccion.Cuenta_rem = cu_rem.Numero_cuenta INNER JOIN cliente as cli_rem ON cu_rem.Cedula = cli_rem.Cedula  INNER JOIN cuenta AS cu_ben ON transaccion.Cuenta_ben = cu_ben.Numero_cuenta INNER JOIN cliente AS cli_ben ON cu_ben.Cedula = cli_ben.Cedula WHERE cu_ben.Numero_Cuenta = ? AND {$campo1} = ? AND {$campo2} = ? ORDER BY transaccion.Id_tra" );
        $consulta->bind_param('sss',$cuenta,$objeto1,$objeto2);
        $consulta->execute();
        $consultado = $consulta->get_result();

        $filas = [];

        while($columnas = $consultado->fetch_assoc()){

            $filas[] = $columnas;

        }

        return $filas;

    }



    public function Post_Filtrar_Estado_Cuenta_Mes($con){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(isset($_POST['mesestado']) && isset($_POST['cuentaestado_mes'])){

                $fecha = $_POST['mesestado'];
                $cuenta = $_POST['cuentaestado_mes'];

                $mes = substr($fecha, 5, 2);

                $año = substr($fecha,0,4);

                $fila = $this->Consulta_Filtrar_Estado_Cuenta_Dos_Campos($con,$cuenta,"MONTH(transaccion.fecha_tra)","YEAR(transaccion.fecha_tra)",$mes,$año);
                
                $fila_rec = $this->Consulta_Filtrar_Estado_Cuenta_Dos_Campos_Recibo($con,$cuenta,"MONTH(transaccion.fecha_tra)","YEAR(transaccion.fecha_tra)",$mes,$año);
                if($fila != null){

               
                    echo '<table id="tb_estado" border = "2">
                    <tr>
    
                    <td> Fecha </td>
                    <td> Hora </td>
                    <td> Cantidad </td>
                    <td> Nombre del depositante </td>
                    <td> Cuenta del depositante </td>
                    <td> Nombre del beneficiario </td>
                    <td> Cuenta del beneficiario </td>
                    <td> Descargar Comprobante </td>
    
    
    
                    </tr>
    
                    '; foreach($fila as $imprimir ){
    
                        
                    echo '
    
                    <tr> 
             
                    <td>'.$imprimir["fecha_tra"].'</td>
                     <td>'.$imprimir["Hora_tra"].'</td>
                     <td>'.$imprimir["Cantidad"].'$ </td>
                     <td>'.$imprimir["Remitente"].'</td>
                     <td>'.$imprimir["Cuenta_rem"].'</td>
                     <td>'.$imprimir["Beneficiario"].'</td> 
                     <td>'.$imprimir["Cuenta_ben"].'</td>
                      <td><form action="../recursos/PDF/Plantillas/Recibo_transacción.php" METHOD="POST"><input type="hidden" name="txt_id_tran" id="txt_id_tra" value="'.htmlspecialchars($imprimir["Id_tra"]).'"><input type="submit" name="btn_mostrar_pdf" value="DESCARGAR PDF"></form></td>
                    </tr>
    
    
                    ';  
                    }
                    echo '</table>'; 

                }
    
                    if($fila_rec != null){
    
    
                    
    
                    echo '<br><br><br>';
                    
    
                    echo '<h2><label for=""> Transferencias Recibidas  </label></h2>';
    
                    echo '<table id="tb_estado_rec" border = "2">
                    <tr>
    
                    <td> Fecha </td>
                    <td> Hora </td>
                    <td> Cantidad </td>
                    <td> Nombre del depositante </td>
                    <td> Cuenta del depositante </td>
                    <td> Nombre del beneficiario </td>
                    <td> Cuenta del beneficiario </td>
                    
    
    
    
                    </tr>

                    
    
                    ';
                    
                    
                    
                    foreach($fila_rec as $imprimir ){
    
                        
                    echo '
    
                    <tr> 
             
                    <td>'.$imprimir["fecha_tra"].'</td>
                     <td>'.$imprimir["Hora_tra"].'</td>
                     <td>'.$imprimir["Cantidad"].'$ </td>
                     <td>'.$imprimir["Remitente"].'</td>
                     <td>'.$imprimir["Cuenta_rem"].'</td>
                     <td>'.$imprimir["Beneficiario"].'</td> 
                     <td>'.$imprimir["Cuenta_ben"].'</td>
                      
                    </tr>
    
    
                    '; }
    
    
                    echo '</table>';
            
                }  
                
                    if($fila_rec == null && $fila == null ){

                    
                
                    echo ' <button type="button" onclick="MostrarEstado()">Volver a mostrar Todas las transacciónes </button>';
                }

            }

        }


    }

    public function Get_Numero_Cuenta_Transaccion($con,$id_tra){

        $obtener = $con->prepare("SELECT transaccion.Cuenta_rem FROM transaccion WHERE Id_tra = ?");
        $obtener->bind_param('s',$id_tra);
        $obtener->execute();
        $obtenido = $obtener->get_result();
        
        $columna = "";
        
        if($obtenido->num_rows > 0){

            $valor = $obtenido->fetch_assoc();
            $columna = $valor['Cuenta_rem'];


        }

        return $columna;


    }

    public function Get_Fecha_Transaccion($con,$id_tra){

        $obtener = $con->prepare("SELECT transaccion.fecha_tra FROM transaccion WHERE Id_tra = ?");
        $obtener->bind_param('s',$id_tra);
        $obtener->execute();
        $obtenido = $obtener->get_result();
        
        $columna = "";
        
        if($obtenido->num_rows > 0){

            $valor = $obtenido->fetch_assoc();
            $columna = $valor['fecha_tra'];


        }

        return $columna;

    }
    public function Get_Hora_Transaccion($con,$id_tra){

        $obtener = $con->prepare("SELECT transaccion.Hora_tra FROM transaccion WHERE Id_tra = ?");
        $obtener->bind_param('s',$id_tra);
        $obtener->execute();
        $obtenido = $obtener->get_result();
        
        $columna = "";
        
        if($obtenido->num_rows > 0){

            $valor = $obtenido->fetch_assoc();
            $columna = $valor['Hora_tra'];


        }

        return $columna;


        }


    public function Get_Saldo_Archivo($con,$cuenta,$fecha,$hora){
        
        $saldo_archivado = 0.0;
        
        //Obtener_fecha_pasada() es una funcion que yo el Desarrollador realice en sql con la consulta SELECT ((SELECT SUM(transaccion.Cantidad) FROM `transaccion` WHERE transaccion.Cuenta_rem = cuenta_rem AND transaccion.fecha_tra <= fec_tra) - (SELECT SUM(transaccion.Cantidad) FROM `transaccion` WHERE transaccion.Cuenta_ben = cuenta_ben AND transaccion.fecha_tra <= fec_tra))
        // formula saldo_archivado = Total de cantidad de transacciones enviadas hasta la fecha de impresión - Total de cantidad de transacciones recibidas hasta la fecha de impresión 
        $consulta = $con->prepare("SELECT Obtener_saldo_archivado(?,?,?) AS 'saldo_archivado'");
        $consulta->bind_param('sss',$cuenta,$fecha,$hora);
        $consulta->execute();
        $consultado = $consulta->get_result();

        if($consultado->num_rows > 0){

            $columna = $consultado->fetch_assoc();
            $saldo_archivado = $columna['saldo_archivado'];

            

        }

        return $saldo_archivado;



    }

    



    
    

}


// conexion ajax
include  $_SERVER['DOCUMENT_ROOT'] ."../recursos/bd/bd.php";

$cone = $conexion;

$cli = new Cliente();

$cli->Post_Mostrar_datos_transaccion($cone);


$cli->Post_Mostrar_Estado_Cuenta($cone);

$cli->Post_Filtrar_Estado_Cuenta_Fecha($cone);

$cli->Post_Filtrar_Estado_Cuenta_Mes($cone);













?>
