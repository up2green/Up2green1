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

    public function getOneShopResult() {
		$result = Doctrine::getTable('engine')
			->getArraySearch(htmlspecialchars($this->search_text), 1, 0);

		$result = $result[0];

		if(!empty($result)) {
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

		$isFirst = preg_match('\.php&', $subject) || preg_match('\/&', $subject);
		$idUser = $this->getUser()->isAuthenticated() ? $this->getUser()->getId() : 0;

		$result['site_url'] .= $isFirst ? '?' : '&';
		$result['site_url'] .= 'up2greenUserId='.$this->getUser()->getId();


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

		$gains = '<img src="/images/icons/16x16/arbre.png" alt="Arbre(s)" />';

		$from = $result['remun_min'];
		$to = $result['remun_max'];

		if($result['remun_type'] === 'pourcent') {
			$from = $from * 30 / (sfConfig::get('app_prix_arbre') * 100);
			$to = $to * 30 / (sfConfig::get('app_prix_arbre') * 100);
			$gains .= " pour 30€ d'achat";
		}

		$from = (floor($from) == $from) ? (int)$from : number_format($from, 2, ',', ' ');
		$to = (floor($to) == $to) ? (int)$to : number_format($to, 2, ',', ' ');

		$result['gains'] = ($from !== $to) ?
			"de <strong>".$from."</strong> à <strong>".$to.'</strong> '.$gains :
			'<strong>'.$from.'</strong> '.$gains;

		$result = array_map('htmlspecialchars', $result);
		return $result;
	}

}
//<source>Fox News</source>
//      <sourceurl>http://www.foxnews.com/</sourceurl>
?>
