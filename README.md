Controller a chequear:
WebsitesController    

Las acciones no siguen las convenciones de API RESTFUL a falta de tiempo

Deberian ser:
GET sites/ID
GET sites?filter=top100
POST sites    body { 'siteUrl' => 'www.google.com'}
 

pero son:
websites/getSite($siteId)
websites/topVisited
websites/addSite    body { 'siteUrl' => 'www.google.com'}
websites/testCreateSite/{url}


El job se ejecuta yendo a la carpeta "[PROYECTO]/app/Console" y luego ingresando 
"./cake crawler crawlSites"
Este job busca todos los sitios que aun no hayan sido crawled y en caso de encontrar un tag de title lo guarda en la DB en el campo title y setea un flag para evitar volver a crawlear.

