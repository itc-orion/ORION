(function(){
    var login = document.formulario_login,
        elementos = login.elements;

    //funciones
    var validarInputs = function(){
        for(var i = 0; i<elementos.length; i++){
            if(elementos[i].type == "email" || elementos[i].type == "password"){
                if (elementos[i].value == 0) {
                    console.log("El campo "+elementos[i].name +" está vacio");
                    elementos[i].className = elementos[i].className + " error";
                    return false;
                }else{
                    elementos[i].className = elementos[i].className.replace(" error", "");
                }
            }
        }
        return true;
    };

    var enviar = function(e){
        if(!validarInputs()){
            console.log("No se han validado los inputs");
            e.preventDefault();
        }else{
            console.log("Si Jala");
            //Codigo para enviar datos de login al servidor 
        }
    };

    //funciones blur y focus
    var focusInput = function(){
        this.parentElement.children[1].className = "label active";
        this.parentElement.children[0].className = this.parentElement.children[0].className.replace(" error", "");
    };

    var blurInput = function(){
        if(this.value <= 0){
            this.parentElement.children[1].className = "label";
            this.parentElement.children[0].className = this.parentElement.children[0].className + " error";
        }
    };

    //eventos
    login.addEventListener("submit", enviar);

    for(var i = 0; i<elementos.length; i++){
        if(elementos[i].type == "email" || elementos[i].type == "password"){
            elementos[i].addEventListener("focus", focusInput);
            elementos[i].addEventListener("blur", blurInput);
        }
    }
}())