let geojson={};

var dominio = "https://7c72a567.ngrok.io"
var urlPOST = dominio+"/Orion_1.1/API/All/Create"
var urlGET = dominio+"/Orion_1.1/API/All/Show"


var formulario = document.getElementById('enviar');

formulario.addEventListener('click', function (e) {
    e.preventDefault();

    let campos = document.querySelectorAll(".campo")

    var datos = {
        "semaforo": {
            "nombre": campos[2].value + "",
            "status": true,
            "longitud": campos[1].value,
            "latitud": campos[0].value,
            "tiempo_inicio": 0,
            "inicio_suspencion": campos[6].value,
            "fin_suspencion": campos[7].value,
            "tiempo_verde": campos[3].value,
            "tiempo_amarillo": campos[4].value,
            "tiempo_rojo": campos[5].value
        },
        "area": geojson
    };


   if(Object.keys(geojson).length!=0)
   {

    HttpRequestPOST(urlPOST, datos)
    .then(res => {
        console.log(res)
    });

    console.log(geojson)

    geojson={}

   }

   for(let i =0; i<campos.length; i++){
        campos[i].value = ""
   }

})

