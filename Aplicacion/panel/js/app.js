
var formulario = document.getElementById('enviar');

formulario.addEventListener('click', function(e){
    e.preventDefault();

    var datos = document.getElementById('form');
    
    console.log(datos);
    
})