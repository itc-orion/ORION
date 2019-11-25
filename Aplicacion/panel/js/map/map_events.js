let coordinates = []

//Evento que se ejecuta cada vez que se dibuja un vertice de un poligono en el mapa
map.on('pm:drawstart', ({ workingLayer }) => {
  workingLayer.on('pm:vertexadded', e => {
    coordinates.push([e.latlng.lng, e.latlng.lat]);

  });
});


//Evento que se ejecuta cada vez que se termina de dibujar en el mapa
map.on('pm:drawend', e => {

  //Cada vez que se dibuja un poligono
  if (e.shape == "Polygon") {
    geojson['type'] = 'Polygon';
    coordinates.push(coordinates[0])
    geojson['coordinates'] = [coordinates]

    coordinates = []


  }
});


//Evento que se ejecuta cada vez que se coloca un marcador
map.on('pm:create', e => {

  if (e.shape == "Marker") {
    let data = document.getElementById("primero")
    data.childNodes[0].value = e.marker._latlng.lat
    data.childNodes[1].value = e.marker._latlng.lng

    map.pm.enableDraw('Polygon', {
      snappable: true,
      snapDistance: 20,

    });

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
  var marcador = new L.marker([e.marker._latlng.lat, e.marker._latlng.lng]).on('click', onClick) 
  //se agrega el marcador a map
  marcador.addTo(map)
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



