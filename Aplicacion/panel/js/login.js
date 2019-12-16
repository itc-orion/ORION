function Sesion(){
    var form_login = document.formulario_login, //variable que toma el formulario
            elementos = form_login.elements; //variable que toma los inputs

        //funciones
        //funcion que revisa que no haya campos vacios y si lo hay coloca un estilo diferente
        var validarInputs = function () { 
            for (var i = 0; i < elementos.length; i++) {
                if (elementos[i].type == "email" || elementos[i].type == "password") {
                    if (elementos[i].value == 0) {
                        console.log("El campo " + elementos[i].name + " está vacio");
                        elementos[i].className = elementos[i].className + " error";
                        return false;
                    } else {
                        elementos[i].className = elementos[i].className.replace(" error", "");
                    }
                }
            }
            return true;
        };

        //funcion que valida los datos de email y contraseña
        var enviar = function (e) {
            if (!validarInputs()) {
                //Si algun campo esta vacio
                new Noty({
                    text: 'Ups! Creo que se te ha olvidado proporcionar la información',
                    layout: 'topRight',
                    theme: 'mint',
                    timeout: 5000,
                    progressBar: true,
                }).show();
                e.preventDefault();
            } else {
                e.preventDefault();
                if (elementos[0].value == "sistemadesemaforosdigitales@gmail.com" && elementos[1].value == "tecnmcuautla") {
                    if (typeof(Storage) !== "undefined") {
                        //Si los datos son correctos almacena una bandera en sessionStorage
                        sessionStorage.setItem("login", true);
                        window.location="index.html";
                    } else {  }
                } else {
                    //Si los datos son incorrectos, crea una notificación
                    new Noty({
                        text: 'Ups! No se ha podido iniciar sesión. Por favor, verifica la información',
                        layout: 'topRight',
                        theme: 'mint',
                        timeout: 5000,
                        progressBar: true,
                    }).show();
                }
            }
        };

        //funciones blur y focus
        var focusInput = function () {
            this.parentElement.children[1].className = "label active";
            this.parentElement.children[0].className = this.parentElement.children[0].className.replace(" error", "");
        };

        var blurInput = function () {
            if (this.value <= 0) {
                this.parentElement.children[1].className = "label";
                this.parentElement.children[0].className = this.parentElement.children[0].className + " error";
            }
        };

        //eventos
        form_login.addEventListener("submit", enviar);

        for (var i = 0; i < elementos.length; i++) {
            if (elementos[i].type == "email" || elementos[i].type == "password") {
                elementos[i].addEventListener("focus", focusInput);
                elementos[i].addEventListener("blur", blurInput);
            }
        }
}

Sesion();