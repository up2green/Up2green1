<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchEngineclass
 *
 * @author TiteiKo
 */
class SearchEngine {
    const GOOGLE = 1;
    const YAHOO = 2;
    const BING = 3;

    private $search_moteur ;
    private $search_text;
    private $search_results;
    
    function  __construct($text, $moteur) {
        $this->search_text = $text;
        $this->search_moteur = $moteur;
        $this->search_results = array();
    }

    public function getNbResults(){
        return sizeof($this->search_results);
    }
    public function getResults($max = 10){
        
    }
}
?>
