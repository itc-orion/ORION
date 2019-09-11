// Funcion para dibujar areas almacenados en el servidor 

function DrawAreas()
{

// Obtiene todas las areas o poligonos y los dibuja en el mapa
HttpRequestGET(urlGET).then(function(myJson)
{


  let data=JSON.parse(myJson)
  if(data.Semaforos!=undefined){

    for(let i=0;i<data.Semaforos.length;i++)
    {

     
      L.geoJSON(data.Semaforos[i].area.object,{
        "color": "yellow"
    
      }).addTo(map);

    }
  }

});

}

DrawAreas()