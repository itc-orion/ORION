let geojson={};

var form = document.getElementById('enviar');
var view = document.getElementById('view');
var del = document.getElementById('eliminar');
let campos = document.querySelectorAll(".campo")

//funcion constructora de peticion para guardar y actualizar
form.addEventListener('click', function (e) {
    e.preventDefault();

    var datos = {
        "semaforo": {
            "nombre": campos[2].value + "",
            "status": true,
            "longitud": parseFloat(campos[1].value),
            "latitud": parseFloat(campos[0].value),
            "tiempo_inicio": 0,
            "inicio_suspencion": campos[7].value,
            "fin_suspencion": campos[6].value,
            "tiempo_verde": parseInt(campos[3].value),
            "tiempo_amarillo": parseInt(campos[4].value),
            "tiempo_rojo": parseInt(campos[5].value)
        },
        "area": geojson
    };

    HttpRequestPOST(urlPOST, datos)
    .then(res => {
        alert(res);
    });


   for(let i =0; i<campos.length; i++){
        campos[i].value = ""
   }

})


//funcion constructora de peticion para eliminar
del.addEventListener('click', function(){
    var datos = {
        "rango":{
            "longitud": parseFloat(campos[1].value),
            "latitud": parseFloat(campos[0].value),
        }
    }
    HttpRequestDELETE(url3, datos)
    .then(res => {
        alert(res);
    })
})