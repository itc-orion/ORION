//Crea mapa y asigna las coordenadas en que se mostrara
  var map = L.map('map').setView([18.828411453309435,-98.9173293374312], 20);

//Mosaicos o Basemaps para mostrar en el mapa
  var basemaps = [
    //Basemaps de Google Maps
    L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
      maxZoom: 20,
      subdomains:['mt0','mt1','mt2','mt3'],
      label: 'Google Maps'
    }),
    //Basemaps de Google Maps Satelite
    L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
      maxZoom: 20,
      subdomains:['mt0','mt1','mt2','mt3'],
      label: 'Google Maps Satelite'
    }),
    //Basemaps de Open Street Map
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
      label: 'Open Street Map'
    })
  ];

//Control para seleccionar Basemaps en el mapa
  map.addControl(L.control.basemaps({
    basemaps: basemaps,
    tileX: 0,  // tile X coordinate
    tileY: 0,  // tile Y coordinate
    tileZ: 1   // tile zoom level
  }));

//Controles para dibujar sobre el mapa
  map.pm.addControls({
    position: 'topleft',
    drawCircle: false,
    drawCircleMarker: false,
    drawPolyline: false,
    drawRectangle:false
  });

//Opciones del color de las areas o poligonos dibujados en el mapa
  map.pm.setPathOptions({
    color: 'yellow',
    fillColor: 'yellow',
    fillOpacity: 0.3,
  });

//Control para modo pantalla completa del mapa
  map.addControl(new L.Control.Fullscreen());

//Control para buscar lugares en el mapa
  var searchControl = new L.esri.Controls.Geosearch({
    position: 'topright'
  }).addTo(map);