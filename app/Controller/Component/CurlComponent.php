
<?php
App::uses('Component', 'Controller');

class CurlComponent extends CakeObject {


	public function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
    }


	function startup(Controller $controller) {
		$this->controller = &$controller;
	}

    function initialize(Controller $controller, $settings = []) {
	}
	
	function beforeRender(Controller $controller) {
   	}

   	function beforeRedirect(Controller $controller) {
   	}

   	function shutdown(Controller $controller) {
   	}



    public function post( $url, $params) {
         
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params,
        );
        
        $ch = curl_init();        
        curl_setopt_array($ch, $defaults);

        curl_exec($ch);
        curl_close($ch);


    }

    public function get($url, $params = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        $data = curl_exec($ch); 
        curl_close($ch); 
        return $data; 

    }



}

?>

