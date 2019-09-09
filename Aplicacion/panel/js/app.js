
var formulario = document.getElementById('enviar');

formulario.addEventListener('click', function(e){
    e.preventDefault();

   let campos=document.querySelectorAll(".campo")

   
    document.querySelector(".nombre").value=""

   for(i=0;i<campos.length;i++){
       campos[i].value=""
   }
    
})




