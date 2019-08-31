// Funcion para dibujar areas almacenados en el servidor 

function DrawAreas()
{

// Obtiene todas las areas o poligonos y los dibuja en el mapa
HttpRequest('http://localhost:80/get.php').then(function(myJson)
{

  let data=JSON.parse(myJson)
    for(let i=0;i<data.count;i++)
    {
      L.geoJSON(data.objects[i].object,{
        "color": "yellow"
    
      }).addTo(map);
    }

});

}

DrawAreas()