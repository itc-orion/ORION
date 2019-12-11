let geojson={};

var dominio = "https://32d1dd76.ngrok.io"
var urlPOST = dominio+"/Orion_1.1/API/All/Create"
var urlGET = dominio+"/Orion_1.1/API/All/Show"
var url2 = dominio+"/Orion_1.1/API/All/Select"
var url3 = dominio+"/Orion_1.1/API/All/Delete"


var form = document.getElementById('enviar');
var view = document.getElementById('view');
var del = document.getElementById('eliminar');
let campos = document.querySelectorAll(".campo")

form.addEventListener('click', function (e) {
    e.preventDefault();

    console.log("HOLA");

    var datos = {
        "semaforo": {
            "nombre": campos[2].value + "",
            "status": true,
            "longitud": parseFloat(campos[1].value),
            "latitud": parseFloat(campos[0].value),
            "tiempo_inicio": 0,
            "inicio_suspencion": campos[6].value,
            "fin_suspencion": campos[7].value,
            "tiempo_verde": parseInt(campos[3].value),
            "tiempo_amarillo": parseInt(campos[4].value),
            "tiempo_rojo": parseInt(campos[5].value)
        },
        "area": geojson
    };

    console.log(datos);

   
    console.log("Entro");
    HttpRequestPOST(urlPOST, datos)
    .then(res => {
        alert(res);
    });


   for(let i =0; i<campos.length; i++){
        campos[i].value = ""
   }

})

view.addEventListener('click', function(){
    if(this.checked == true){
        Streetview();
    }else{
        Mapview();
    }
    
})

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