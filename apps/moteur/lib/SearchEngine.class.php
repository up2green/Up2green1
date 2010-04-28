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
    const IMG = 1;
    const WEB = 2;
    const NEWS = 3;

    private $search_moteur ;
    private $search_text;
    private $search_results;

    function  __construct($text, $moteur) {
        $this->search_text = $text;
        $this->search_moteur = $moteur;
        $this->search_results = array();
        
    }

    public function getNbResults() {
        return sizeof($this->search_results);
    }
    public function getResults($min = 0, $max = -1) {
        switch ($this->search_moteur) {
            case self::IMG:
                $this->executeImg($min);
                break;
            case self::WEB:
                $this->executeWeb($min);
                break;
            case self::NEWS:
                $this->executeNews($min);
                break;
        }
        
        return $this->search_results;
    }


    private function executeImg($min=0) {
        $url = "http://boss.yahooapis.com/ysearch/images/v1/" .urlencode($this->search_text);
        $url .= "?appid=" . sfConfig::get('app_yahoo_id');
        $url .= "&format=xml";
        $url .= "&start=".$min;
        $url .= "&count=".($min == 0 ? sfConfig::get('app_base_search') : sfConfig::get('app_more_search'));
        $url .= "&lang=fr";
        $url .= "&region=fr";
//        die($url);
        $dom = new DomDocument();
        $dom->load($url);
        $dom->save("test.xml");
        foreach ($dom->getElementsByTagName("result") as $result){
            $this->search_results[] = array(
                'title' => $result->getElementsByTagName('title')->item(0)->nodeValue,
                'content' => $result->getElementsByTagName('abstract')->item(0)->nodeValue,
                'clickUrl' => $result->getElementsByTagName('clickurl')->item(0)->nodeValue,
                'displayUrl' => $result->getElementsByTagName('refererurl')->item(0)->nodeValue,
                'thumbnail' => $result->getElementsByTagName('thumbnail_url')->item(0)->nodeValue
                );
        }
    }

    private function executeWeb($min = 0) {
        $url = "http://boss.yahooapis.com/ysearch/web/v1/" .urlencode($this->search_text);
        $url .= "?appid=%20Kj_TvU_V34EbCKKfZ4yPkczw6EL_AFnECTq9EVUyhMyTGgpSf97RhYE6KHWsPQ--";
        $url .= "&format=xml";
        $url .= "&start=".$min;
        $url .= "&count=".($min == 0 ? sfConfig::get('app_base_search') : sfConfig::get('app_more_search'));
        $url .= "&lang=fr";
        $url .= "&region=fr";
//        die($url);
        $dom = new DomDocument();
        $dom->load($url);
        $dom->save("test.xml");
        foreach ($dom->getElementsByTagName("result") as $result){
            $this->search_results[] = array(
                'title' => $result->getElementsByTagName('title')->item(0)->nodeValue,
                'content' => $result->getElementsByTagName('abstract')->item(0)->nodeValue,
                'clickUrl' => $result->getElementsByTagName('clickurl')->item(0)->nodeValue,
                'displayUrl' => $result->getElementsByTagName('dispurl')->item(0)->nodeValue,
                );
        }
    }

     private function executeNews($min = 0) {
        $url = "http://boss.yahooapis.com/ysearch/news/v1/" .urlencode($this->search_text);
        $url .= "?appid=%20Kj_TvU_V34EbCKKfZ4yPkczw6EL_AFnECTq9EVUyhMyTGgpSf97RhYE6KHWsPQ--";
        $url .= "&format=xml";
        $url .= "&start=".$min;
        $url .= "&count=".($min == 0 ? sfConfig::get('app_base_search') : sfConfig::get('app_more_search'));
        $url .= "&lang=fr";
        $url .= "&region=fr";
//        die($url);
        $dom = new DomDocument();
        $dom->load($url);
        $dom->save("test.xml");
        foreach ($dom->getElementsByTagName("result") as $result){
            $this->search_results[] = array(
                'title' => $result->getElementsByTagName('title')->item(0)->nodeValue,
                'content' => $result->getElementsByTagName('abstract')->item(0)->nodeValue,
                'clickUrl' => $result->getElementsByTagName('clickurl')->item(0)->nodeValue,
                'source' => $result->getElementsByTagName('source')->item(0)->nodeValue,
                'source_url' => $result->getElementsByTagName('sourceurl')->item(0)->nodeValue,
                );
        }
    }
}
//<source>Fox News</source>
//      <sourceurl>http://www.foxnews.com/</sourceurl>
?>
