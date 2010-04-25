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

        switch ($moteur) {
            case self::GOOGLE:
                $this->executeGoogle();
                break;
            case self::YAHOO:
                $this->executeYahoo();
                break;
            case self::BING:
                $this->executeBing();
                break;
        }
    }

    public function getNbResults() {
        return sizeof($this->search_results);
    }
    public function getResults($min = 0, $max = -1) {
        if ($max == -1) $max = sfConfig::get('app_max_item_search');
        $arrResults = array();
        for ($i = $min; $i < $max && $i < sizeof($this->search_results); $i++){
            $arrResults[] = $this->search_results[$i];
        }
        return $arrResults;
    }


    private function executeGoogle() {
        $this->search_results[] = array('title' => "Recherche google 1", 'content' =>"Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche google 2', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche google 3', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche google 4', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche google 5', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche google 6', "content" => "Blablablabla blablabla");
    }

    private function executeYahoo() {
        $this->search_results[] = array('title' => "Recherche yahoo 1", 'content' =>"Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche yahoo 2', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche yahoo 3', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche yahoo 4', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche yahoo 5', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche yahoo 6', "content" => "Blablablabla blablabla");
    }

    private function executeBing() {
        $this->search_results[] = array('title' => "Recherche bing 1", 'content' =>"Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche bing 2', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche bing 3', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche bing 4', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche bing 5', "content" => "Blablablabla blablabla");
        $this->search_results[] = array('title' => 'Recherche bing 6', "content" => "Blablablabla blablabla");

    }
}
?>
