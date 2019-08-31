//Crea mapa y asigna las coordenadas en que se mostrara
var map = L.map('map',{preferCanvas: true}).setView([18.82804842135663,-98.91869496336972], 20);

// Moscaico google maps 
L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
  maxZoom: 20,
  subdomains:['mt0','mt1','mt2','mt3']
}).addTo(map);


    /* Mosaico open street map 
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    */


    /* Mosaico satelital google maps
    L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
      maxZoom: 20,
      subdomains:['mt0','mt1','mt2','mt3']
    }).addTo(map);
    */

//Opciones de la barra de acciones
map.pm.addControls({
    position: 'topleft',
    drawCircle: false,
    drawCircleMarker: false,
    drawPolyline: false,
    drawRectangle:false
  });

//Opciones del color de las areas o poligonos
map.pm.setPathOptions({
    color: 'yellow',
    fillColor: 'yellow',
    fillOpacity: 0.2,
  });


