

function MostrarEstado(){

    var cuenta = document.getElementById('cb_cu_es').value;

    var objeto = new XMLHttpRequest;
    objeto.open('POST', '../../Modelo/Cliente.php',true);
    objeto.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    objeto.onreadystatechange = function () {

        document.getElementById("contenedor_tab_est").innerHTML = objeto.response;
        console.log(objeto.responseText);
        

    }

    objeto.send("cuenta_est=" + encodeURIComponent(cuenta));

    var opcion_seleccionar = document.getElementById('opt_sel_est');

    opcion_seleccionar.remove();


    

}









function Filtrar_Fecha(){


    var fecha = document.getElementById("tx_fe").value;
    var cuenta = document.getElementById('cb_cu_es').value;

    var objeto = new XMLHttpRequest();
    objeto.open("POST","../../Modelo/Cliente.php");
    objeto.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    objeto.onreadystatechange = function (){
        

    if (objeto.readyState === 4 && objeto.status === 200) {  
        if(objeto.response.trim() === ""){
            alert("No se han encontrado resultados");
        }
        document.getElementById("contenedor-filtro").innerHTML = objeto.response;
        console.log(objeto.responseText);

    }

  };

    objeto.send("fecha="+encodeURIComponent(fecha)+"&cuentaestado="+encodeURIComponent(cuenta))
    


}

function Filtrar_Mes(){


    var mes = document.getElementById("inp_mes_est").value;
    var cuenta = document.getElementById('cb_cu_es').value;

    var objeto = new XMLHttpRequest();
    objeto.open("POST","../../Modelo/Cliente.php");
    objeto.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    objeto.onreadystatechange = function (){
        

    if (objeto.readyState === 4 && objeto.status === 200) {  
        if(objeto.response.trim() === ""){
            alert("No se han encontrado resultados");
        }
        document.getElementById("contenedor-filtro").innerHTML = objeto.response;
        console.log(objeto.responseText);

    }

  };

    objeto.send("mesestado="+encodeURIComponent(mes)+"&cuentaestado_mes="+encodeURIComponent(cuenta))
    


}

