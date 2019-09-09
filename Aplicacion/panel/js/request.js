//Realizar peticion al servidor, retorna un promise
function HttpRequest(url)
{

let data=fetch(url).then(function(response){return response.text()});
return data;

}
