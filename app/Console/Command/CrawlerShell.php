<?php 

App::import('WebsiteInformation', 'Model');

App::import('Component', 'Curl');


class CrawlerShell extends Shell {

    var $uses = array('WebsiteInformation');
    var $components = array('Curl');
    public function startup()
    {
        
    }

    
	function main() {}


    function crawlSites() {

        $this->WebsiteInformation = new WebsiteInformation();   
        $sitesToCrawl = $this->WebsiteInformation->find('all', [ 
            'conditions' => [
                'crawled' => false
            ]
        ]);

        if(!empty($sitesToCrawl)) {

            foreach($sitesToCrawl as $site) {

                // Aqui tuve un inconveniente con el llamado al componente.. y para no demorar mas copie el GET,
                // Demas esta decir que deberia instanciar al componente y no repetir codigo. 

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $site['WebsiteInformation']['url']); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                curl_setopt($ch, CURLOPT_HEADER, 0); 
                $data = curl_exec($ch); 
                curl_close($ch); 
                
                if(preg_match("/<title>(.+)<\/title>/i", $data, $matches)) {

                    if(isset($matches[1])) {
                        $this->WebsiteInformation->id = $site['WebsiteInformation']['id'];
                        $this->WebsiteInformation->saveField('title', $matches[1]);
                        $this->WebsiteInformation->saveField('crawled', 1);
                    }
                } else
                    var_dump($site['WebsiteInformation']['url'] . ": The page doesn't have a title tag ??? \n");




            }
        }


    }

}


?>


