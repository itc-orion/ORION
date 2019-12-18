// create the sidebar instance and add it to the map
var sidebar = L.control.sidebar({ container: 'sidebar' }).addTo(map)

 // be notified when a panel is opened
sidebar.on('content', function (ev) {
  
    console.log(ev.id)


  
});



  

