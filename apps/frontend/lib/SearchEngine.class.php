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
    const PUB = 5;

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

    public function getOneShopResult($min = 0) {
		$result = Doctrine::getTable('engine')
			->getArraySearch(htmlspecialchars($this->search_text), 1, $min);

		if(!empty($result)) {
			$result = $result[0];
			$this->processShopResult($result);
		}
		
		return $result;
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
			case self::PUB:
                $this->executePub($min);
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
            $content = $result->getElementsByTagName('abstract')->item(0)->nodeValue;
			$content = strip_tags($content);

			if(strlen($content) > 30) {
				$coupurePropre = strpos($content, ' ', 30);
				if($coupurePropre > 40) {
					$coupurePropre = 30;
				}

				$content = substr($content, 0, $coupurePropre).' ...';
			}

            $this->search_results[] = array(
                'title' => $result->getElementsByTagName('title')->item(0)->nodeValue,
                'content' => $content,
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

	public function getPubResults($nombre = 2, $min = 0) {

		$nombre += $min;
		
		$url = sfConfig::get('app_ddc_hostname');
		$url .= sfConfig::get('app_ddc_path');
		$url .= "?n=".$nombre;
		$url .= "&kw=".urlencode($this->search_text);
		$url .= "&cb=".uniqid();
		$url .= "&c=".sfConfig::get('app_ddc_id');
		$url .= "&surl=http://up2green.com/";
		$url .= "&ua=".$_SERVER['HTTP_USER_AGENT'];

		if(sfContext::getInstance()->getConfiguration()->getEnvironment() !== 'dev') {
			$url .= "&ip=".$_SERVER['REMOTE_ADDR'];
		}
		else {
			$url .= "&ip=92.243.6.168";
		}
		
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$url .= "&xfip=".$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		
		$dom = new DomDocument();
		$dom->load($url);
		$results = array();

		$i= 0;
		foreach ($dom->getElementsByTagName("ad") as $result){
			if($i < $min) {
				$i++;
				continue;
			}
			$results[] = array(
				'title' => $result->getElementsByTagName('title')->item(0)->nodeValue,
				'description' => $result->getElementsByTagName('description')->item(0)->nodeValue,
				'url' => $result->getElementsByTagName('url')->item(0)->nodeValue,
				'visibleurl' => $result->getElementsByTagName('url')->item(0)->getAttribute('visibleurl'),
			);
		}
		
		return $results;
	}

	private function executeShop($min = 0) {

		$results = Doctrine::getTable('engine')->getArraySearch(
			htmlspecialchars($this->search_text),
			$min == 0 ? sfConfig::get('app_base_search') : sfConfig::get('app_more_search'),
			$min
		);

		foreach ($results as $id => $result){
			$results[$id] = $this->processShopResult($result);
		}

		$this->search_results = $results;

	}

	private function processShopResult(&$result) {
		$result = array_map('trim', $result);
		$result = array_map(array('SearchEngine', 'addUrlId'), $result);
		
		$linkOpen = '<a target="_blank" href="'.$result['site_url'].'">';

		if(substr($result['logo'], 0, 7) === 'http://') {
			$result['logo'] = $linkOpen.'<img src="'.$result['logo'].'" alt="'.$result['site_display'].'" /></a>';
		}
		elseif(substr($result['logo'], 0, 3) === '<a ') {
			$result['logo'] = '<a target="_blank" '.substr($result['logo'], 3);
		}

		if(empty($result['html'])) {
			$result['html'] = '
				<h3>'.$linkOpen.$result['site_display'].'</a></h3>
				<p>'.$result['description'].'</p>
			';
		}

		$result = array_map('htmlspecialchars', $result);
		return $result;
	}

	private static function addUrlId($value) {
		$idUser = sfContext::getInstance()->getUser()->isAuthenticated()
				? sfContext::getInstance()->getUser()->getGuardUser()->getId()
				: Doctrine::getTable('sfGuardUser')->getUp2greenId();

		return str_replace('{up2greenId}', $idUser, $value);
	}

}
//<source>Fox News</source>
//      <sourceurl>http://www.foxnews.com/</sourceurl>
?>
