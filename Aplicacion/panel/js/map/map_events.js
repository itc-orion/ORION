let coordinates=[]


//Evento que se ejecuta cada vez que se dibuja un vertice de un poligono en el mapa
map.on('pm:drawstart', ({ workingLayer }) => {
    workingLayer.on('pm:vertexadded', e => 
    {
      coordinates.push([e.latlng.lng,e.latlng.lat]);

    });
  });

  
//Evento que se ejecuta cada vez que se termina de dibujar en el mapa
map.on('pm:drawend', e => {

    //Cada vez que se dibuja un poligono
    if(e.shape=="Polygon")
    {
      geojson['type']='Polygon';
      coordinates.push(coordinates[0])
      geojson['coordinates']=[coordinates]
    
  
      
      coordinates=[]


    }
});


//Evento que se ejecuta cada vez que se coloca un marcador
map.on('pm:create', e => {

  if(e.shape=="Marker")
    {
      let data=document.getElementById("primero")
      data.childNodes[0].value=e.marker._latlng.lat
      data.childNodes[1].value=e.marker._latlng.lng


      map.pm.enableDraw('Polygon', {
        snappable: true,
        snapDistance: 20,
      
      });

    }

  });

//Evento que se ejecuta cada vez que se elimina cualquier elemento del mapa
map.on('pm:remove', e => {

  //Obtiene coordenadas del area eliminada
 let area=e.layer.feature.geometry.coordinates[0];
  


     
});


