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
    const SHOP = 4;

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
    public function getResults($min = 0) {
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
			case self::SHOP:
                $this->executeShop($min);
                break;
        }
        
        return $this->search_results;
    }


    private function executeImg($min=0) {
        $url = sfConfig::get('app_url_engine_image') .urlencode($this->search_text);
        $url .= "?appid=" . sfConfig::get('app_yahoo_id');
        $url .= "&format=xml";
        $url .= "&start=".$min;
        $url .= "&count=".($min == 0 ? sfConfig::get('app_base_search') : sfConfig::get('app_more_search'));
        $url .= "&lang=fr";
        $url .= "&region=fr";
        
        $dom = new DomDocument();
        $dom->load($url);
        foreach ($dom->getElementsByTagName("result") as $result){
			$displayUrl = trim($result->getElementsByTagName('refererurl')->item(0)->nodeValue);
			$displayUrl = substr($displayUrl, 0, strpos($displayUrl, '/', 7));
            
            $this->search_results[] = array(
                'title' => $result->getElementsByTagName('title')->item(0)->nodeValue,
                'content' => $result->getElementsByTagName('abstract')->item(0)->nodeValue,
                'clickUrl' => $result->getElementsByTagName('clickurl')->item(0)->nodeValue,
                'displayUrl' => $displayUrl,
                'thumbnail' => $result->getElementsByTagName('thumbnail_url')->item(0)->nodeValue
                );
        }
    }

    private function executeWeb($min = 0) {
        $url = sfConfig::get('app_url_engine_web') .urlencode($this->search_text);
        $url .= "?appid=" . sfConfig::get('app_yahoo_id');
        $url .= "&format=xml";
        $url .= "&start=".$min;
        $url .= "&count=".($min == 0 ? sfConfig::get('app_base_search') : sfConfig::get('app_more_search'));
        $url .= "&lang=fr";
        $url .= "&region=fr";
        
        $dom = new DomDocument();
        $dom->load($url);
        foreach ($dom->getElementsByTagName("result") as $result){
            $this->search_results[] = array(
                'title' => htmlspecialchars($result->getElementsByTagName('title')->item(0)->nodeValue),
                'content' => htmlspecialchars($result->getElementsByTagName('abstract')->item(0)->nodeValue),
                'clickUrl' => htmlspecialchars($result->getElementsByTagName('clickurl')->item(0)->nodeValue),
                'displayUrl' => htmlspecialchars($result->getElementsByTagName('dispurl')->item(0)->nodeValue)
                );
        }
    }

	private function executeNews($min = 0) {
		$url = sfConfig::get('app_url_engine_news') . urlencode($this->search_text);
		$url .= "?appid=" . sfConfig::get('app_yahoo_id');
		$url .= "&format=xml";
		$url .= "&age=7d";
		$url .= "&orderby=date";
		$url .= "&start=".$min;
		$url .= "&count=".($min == 0 ? sfConfig::get('app_base_search') : sfConfig::get('app_more_search'));
		$url .= "&lang=fr";
		$url .= "&region=fr";

		$dom = new DomDocument();
		$dom->load($url);
		foreach ($dom->getElementsByTagName("result") as $result){
			$date = $result->getElementsByTagName('date')->item(0)->nodeValue;
			$date = date('d/m/Y', strtotime($date));

			$this->search_results[] = array(
				'title' => $result->getElementsByTagName('title')->item(0)->nodeValue,
				'content' => $result->getElementsByTagName('abstract')->item(0)->nodeValue,
				'clickUrl' => $result->getElementsByTagName('clickurl')->item(0)->nodeValue,
				'source' => $result->getElementsByTagName('source')->item(0)->nodeValue,
				'sourceUrl' => $result->getElementsByTagName('sourceurl')->item(0)->nodeValue,
				'date' => $date,
				'time' => $result->getElementsByTagName('time')->item(0)->nodeValue,
				);
		}
	}

	private function executeShop($min = 0) {
		$url = sfConfig::get('app_url_engine_news') . urlencode($this->search_text);
		$url .= "?appid=" . sfConfig::get('app_yahoo_id');
		$url .= "&format=xml";
		$url .= "&age=7d";
		$url .= "&orderby=date";
		$url .= "&start=".$min;
		$url .= "&count=".($min == 0 ? sfConfig::get('app_base_search') : sfConfig::get('app_more_search'));
		$url .= "&lang=fr";
		$url .= "&region=fr";

		$dom = new DomDocument();
		$dom->load($url);
		foreach ($dom->getElementsByTagName("result") as $result){
			$date = $result->getElementsByTagName('date')->item(0)->nodeValue;
			$date = date('d/m/Y', strtotime($date));

			$this->search_results[] = array(
				'title' => $result->getElementsByTagName('title')->item(0)->nodeValue,
				'content' => $result->getElementsByTagName('abstract')->item(0)->nodeValue,
				'clickUrl' => $result->getElementsByTagName('clickurl')->item(0)->nodeValue,
				'source' => $result->getElementsByTagName('source')->item(0)->nodeValue,
				'sourceUrl' => $result->getElementsByTagName('sourceurl')->item(0)->nodeValue,
				'date' => $date,
				'time' => $result->getElementsByTagName('time')->item(0)->nodeValue,
				);
		}
	}
}
//<source>Fox News</source>
//      <sourceurl>http://www.foxnews.com/</sourceurl>
?>
