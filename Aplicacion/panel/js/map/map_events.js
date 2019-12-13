//Se almacena  temporalmente las coordenadas de los poligonos que se crean.
  let coordinates = []

//Evento que se ejecuta cada vez que se dibuja un vertice de un poligono en el mapa
  map.on('pm:drawstart', ({ workingLayer }) => {
    workingLayer.on('pm:vertexadded', e => {
      coordinates.push([e.latlng.lng, e.latlng.lat]);
    });  
  });
<<<<<<< HEAD
=======
});


//Evento que se ejecuta cada vez que se termina de dibujar en el mapa
map.on('pm:drawend', e => {

  //Cada vez que se dibuja un poligono
  if (e.shape == "Polygon") {
    geojson['type'] = 'Polygon';
    coordinates.push(coordinates[0])
    geojson['coordinates'] = [coordinates]

    coordinates = []

    console.log(JSON.stringify(geojson))

>>>>>>> f842df9b921e107dcc641a65a346d0924c9bda10

//Evento que se ejecuta cada vez que selecciona un elemento a dibujar
  map.on('pm:drawstart', e => {
    if(e.shape=='Marker'){
      e.workingLayer._icon.src=trafficlight_icon;
  }
  });

//Evento que se ejecuta cada vez que se termina de dibujar un elemento en el mapa
  map.on('pm:drawend', e => {
    if (e.shape == "Polygon") {
      geojson['type'] = 'Polygon';
      coordinates.push(coordinates[0])
      geojson['coordinates'] = [coordinates]
      coordinates = []
    }
  });

//Evento que se ejecuta cada vez que se crea un elemento en el mapa
  map.on('pm:create', e => {
    if (e.shape == "Marker") {
      let data = document.getElementById("primero")
      data.childNodes[0].value = e.marker._latlng.lat
      data.childNodes[1].value = e.marker._latlng.lng

      //Notificacion al usuario
      new Noty({
        text: 'Excelente, ahora dibuja el area geografica del semaforo',
        layout: 'topCenter',
        theme: 'metroui',
        timeout: 2500,
        progressBar: true,
      }).show();
      //Habilita el modo dibujar poligono
      map.pm.enableDraw('Polygon', {
        snappable: true,
        snapDistance: 20,
      });
      e.marker.dragging._marker._icon.src=trafficlight_icon;
      agregaMarcador(e);
    }
  });

//Evento que se ejecuta cada vez que se elimina cualquier elemento del mapa
  map.on('pm:remove', e => {
    //Obtiene coordenadas del area eliminada
    let area = e.layer.feature.geometry.coordinates[0];

  });

function agregaMarcador(e) {
  
  //se crea un nuevo marcador y se le asigna el evento que se lanzará al hacerle click
  var marcador = new L.marker( [e.marker._latlng.lat, e.marker._latlng.lng] ).on('click', onClick) 
  
  
  //se agrega el marcador a map
  marcador.addTo(map)
  marcador._icon.src=trafficlight_icon;
  



}

function onClick(e) {
  //Funcion de GET para ver los datos de ese semaforo

  var consulta = {
    "rango":{
      "latitud": e.latlng.lat,
      "longitud": e.latlng.lng
    }
  };

  Consulta(url2, consulta).then(res => {
    let campos = document.querySelectorAll(".campo")

    campos[2].value = res.Semaforo[0].nombre;
    campos[0].value = res.Semaforo[0].latitud;
    campos[1].value = res.Semaforo[0].longitud;
    campos[3].value = res.Semaforo[0].tiempo_verde;
    campos[4].value = res.Semaforo[0].tiempo_amarillo;
    campos[5].value = res.Semaforo[0].tiempo_rojo;
    campos[6].value = res.Semaforo[0].inicio_suspencion;
    campos[7].value = res.Semaforo[0].fin_suspencion;
  })
  
}



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

      var marcador = new L.marker([data.Semaforos[i].latitud, data.Semaforos[i].longitud]).on('click', onClick)
      marcador.addTo(map)

    }
  }

});

}

DrawAreas()