//Realizar peticion al servidor, retorna un promise
function HttpRequestGET(url)
{

let data=fetch(url).then(function(response){return response.text()});
return data;

}

function HttpRequestPOST(url, json)
{
    
    let data=fetch(url, { method: "POST", body: JSON.stringify(json)}).then(res => res.text());
   
   return data;
}

function Consulta(url, json)
{
    let data = fetch(url, 
        {
            method: "POST", 
            body: JSON.stringify(json)
        }).then(res => res.text());

    return data;
}