


function Mostrar_datos_transaccion(){

    var cuenta = document.getElementById("cb_cuen").value;

   var objeto = new XMLHttpRequest();
   objeto.open('POST','../../Modelo/Cliente.php',true);
   objeto.setRequestHeader('Content-type','application/x-www-form-urlencoded');
   objeto.onreadystatechange = function(){

       document.getElementById("lb_saldo").innerHTML = objeto.response;
       console.log(objeto.responseText);
           
   }
   
   objeto.send("cuenta=" + encodeURIComponent(cuenta));

   var opcion_sele = document.getElementById("opt_sel");
   
   opcion_sele.remove();
        

   



}

