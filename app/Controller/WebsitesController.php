<?php


App::uses('AppController', 'Controller');
App::import('WebsiteInformation', 'Model');

class WebsitesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('WebsiteInformation');
    public $components = ["Curl"];

    public function beforeFilter()
    {
        parent::beforeFilter();
        foreach($this->uses as $model) {
            App::uses($model, 'Model');
            $this->$model = new $model;
        }
        $this->CurlComponent = $this->Components->load("Curl");
        $this->WebsiteInformation = new WebsiteInformation();

    }
    
    /**
     * Method GET
     * obtiene por ID informacion del sitio
     * @param int $siteId
     * @return string title 
     */
    public function getSite($siteId) {
        try {
                
            $this->layout = $this->autoRender = false;

            if(!empty($siteId)) {           
                
                $webInfo = $this->WebsiteInformation->find('first', ['conditions' => [
                    'WebsiteInformation.id' => $siteId,
                ],   
                    'fields' => ['url', 'title']
                ]);
                if(!empty($webInfo)) {
                    return "Sitio: " . $webInfo['WebsiteInformation']['url'] . ", Titulo: " . (empty($webInfo['WebsiteInformation']['title']) ? "el sitio no fue crawled aun!" : $webInfo['WebsiteInformation']['title']);  
                } else {
                    $this->response->statusCode(404);
                }

            }
        } catch (Exception $e) {
            $this->response->statusCode(405);
            return $this->response->body(
                $e->getMessage()
            );
        }      
    }

     /**
     * METHOD GET
     * Obtiene un listado de los 100 sitios mas visitados
     * @return JSON listado de sitios ordenado por numero de visitas
     */
    public function topVisited() {

        try {
            $this->layout = $this->autoRender = false;

            $webInfo = $this->WebsiteInformation->find('all', [
                'fields' => ['WebsiteInformation.url','WebsiteInformation.title', 'WebsiteInformation.visits'],
                'order' => 'WebsiteInformation.visits DESC',
                'limit' => 100
            ]);

            if(!empty($webInfo)) {
                // Rearmo el array dejando como key la url y como value el name
                echo json_encode(Set::combine($webInfo, '{n}.WebsiteInformation.url', '{n}.WebsiteInformation.title'));
            } else {
                $this->response->statusCode(404);
            } 
        } catch (Exception $e) {
            $this->response->statusCode(405);
            return $this->response->body(
                $e->getMessage()
            );
        }    
    }

    /**
     * METHOD POST
     * Obtiene un listado de los 100 sitios mas visitados
     * @param int $siteId
     * @return array con status de exito o error y message   
     */
    public function addSite() {

        $this->layout = $this->autoRender = false;
        try {
            if(!empty($this->request->data['siteUrl'] )) {
    
                $this->WebsiteInformation->create();
                if($this->WebsiteInformation->save(['url' => $this->request->data['siteUrl']])) {
                    $this->response->statusCode(201);
                    return ['success' => true, "message" => "Guardado OK!"];
                } else {
                    // 200
                    return ['success' => false, "message" => "Se produjo un erorr al guardar web con valor: {$this->request->data['siteUrl']}!"];
                }
            } else {
                $this->response->statusCode(400);
            }
        } catch (Exception $e) {
            $this->response->statusCode(405);
            return $this->response->body(
                $e->getMessage()
            );
        }
    }

    /**
     * METHOD GET
     * Funcion de prueba para crear nuevo dominio
     * @param string $url
     * @return array con status de exito o error y message   
     */
    public function testCreateSite($url) { 
        $this->layout = $this->autoRender = false;
        if(!empty($url)) {
            $this->Curl->post( "http://testonline.com/websites/addSite", ['siteUrl' => $url]);        
        }        
    }


 
}
