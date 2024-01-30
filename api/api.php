<?php

class ApiHelper {
    private $mainLink;

    public function __construct($mainUrl) {
        $this->mainLink = $mainUrl;
    }

    public function getTvShowById($id) {
        $apiEndpoint = $this->mainLink . 'shows/' . $id;
        
        // Eseguire la richiesta
        $response = file_get_contents($apiEndpoint);

        // Verifica se la richiesta ha avuto successo
        if ($response === false) {
            return 'Errore nella richiesta API';
        }

        // Decodifica il JSON ricevuto
        $data = json_decode($response, true);

        // Verifica se la decodifica del JSON ha avuto successo
        if ($data === null) {
            return 'Errore nella decodifica del JSON';
        }

        return $data;
    }

}

?>
