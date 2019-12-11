<?php
    include_once 'Controllers/AllController.php';
    include_once 'Controllers/ErrorController.php';
    include_once 'Controllers/ValidacionController.php';

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");

    $api_all = new AllController();
    $validar = new ValidacionController();
    $error = new ErrorController();

    if(isset($_GET['url'])){
        $item = $_GET['url'];
        if($_SERVER['REQUEST_METHOD']=='GET'){
            switch($item){
                case "All/Show";
                    $api_all->All();
                break;
                default;
                    $error->Mensaje('La direcion URL no existe');
                break;
            }

        }else if($_SERVER['REQUEST_METHOD']=='POST'){
            $body = file_get_contents('php://input');
            
            if(json_last_error()==0){
                switch($item){
                    case "All/Select";
                        $api_all->Sel($body);
                    break;
                    case "All/Create";
                        $validar->Ins($body);
                    break;
                    case "All/Delete";
                        $api_all->Del($body);
                    break;
                    default;
                        $error->Mensaje("La direcion URL no existe");
                    break;
                }
            }else{
                $error->Mensaje("Solo acepta archivos .json o la estructura del archivo tiene un error");
            }
        }else if($_SERVER['REQUEST_METHOD']=='DELETE'){
            $body = file_get_contents('php://input');
            
            if(json_last_error()==0){
                switch($item){
                    case "All/Delete";
                        $api_all->Del($body);
                    break;
                    default;
                        $error->Mensaje("La direcion URL no existe");
                    break;
                }
            }else{
                $error->Mensaje("Solo acepta archivos .json o la estructura del archivo tiene un error");
            }
        }else{
            $error->Mensaje("El tipo de Operacion que eligio no existe");
        }
    }
?>