<?php

class SearchEngine
{
  const IMG  = 1;
  const WEB  = 2;
  const NEWS = 3;
  const SHOP = 4;
  const PUB  = 5;

  private $search_moteur;
  private $search_text;
  private $search_results;

  function __construct($text, $moteur)
  {
    $this->search_text = self::cleanText($text);
    $this->search_moteur = $moteur;
    $this->search_results = array();
  }

  /**
   * return a string representation of the search type
   * @param integer $key
   * @return string
   */
  public static function getSlug($key)
  {
    switch ($key)
    {
      case self::IMG: return 'img';
      case self::WEB: return 'web';
      case self::NEWS: return 'news';
      case self::SHOP: return 'shop';
      default: return 'default';
    }
  }

  /**
   * return an array of available search types
   * @return array
   */
  public static function getAvailableTypes()
  {
    return array(
      self::IMG,
      self::WEB,
      self::NEWS,
      self::SHOP,
    );
  }

  public function getNbResults()
  {
    return sizeof($this->search_results);
  }

  public function getOneShopResult($min = 0)
  {
    $result = Doctrine::getTable('engine')
      ->getArraySearch(htmlspecialchars($this->search_text), 1, $min);

    if (!empty($result))
    {
      $result = $result[0];
      $this->processShopResult($result);
    }

    return $result;
  }

  public function getResults($min = 0)
  {
    switch ($this->search_moteur)
    {
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

  private function executeImg($min = 0)
  {
    $auth = new up2gYahooOAuth(sfConfig::get('app_oauth_key'), sfConfig::get('app_oauth_secret'));

    $culture = sfContext::getInstance()->getUser()->getCulture() == 'en'
        ? 'en-us'
        : 'fr-fr';

    $response = $auth->call(sfConfig::get('app_url_engine_image'), array(
      'q'      => $this->search_text,
      'format' => 'json',
      'count'  => ($min == 0
          ? sfConfig::get('app_base_search')
          : sfConfig::get('app_more_search')),
      'start'  => $min,
      'market' => $culture
      ));

    $response = json_decode($response);

    if ($response && $response->bossresponse->responsecode == '200')
    {
      foreach ($response->bossresponse->images->results as $result)
      {
        // shorter displayed url
        $displayUrl = trim($result->refererurl);
        $displayUrl = substr($displayUrl, 0, strpos($displayUrl, '/', 7));

        // shorter displayed content
        $content = strip_tags($result->refererurl);

        if (strlen($content) > 30)
        {
          $coupurePropre = strpos($content, ' ', 30);
          $coupurePropre = ($coupurePropre > 40)
              ? 30
              : $coupurePropre;
          $content       = substr($content, 0, $coupurePropre) . ' ...';
        }

        $this->search_results[] = array(
          'title'      => $result->title,
          'content'    => $content,
          'clickUrl'   => $result->clickurl,
          'displayUrl' => $displayUrl,
          'thumbnail'  => $result->thumbnailurl,
        );
      }
    }
  }

  private function executeWeb($min = 0)
  {
    $auth = new up2gYahooOAuth(sfConfig::get('app_oauth_key'), sfConfig::get('app_oauth_secret'));

    $culture = sfContext::getInstance()->getUser()->getCulture() == 'en'
        ? 'en-us'
        : 'fr-fr';

    $response = $auth->call(sfConfig::get('app_url_engine_web'), array(
      'q'      => $this->search_text,
      'format' => 'json',
      'count'  => ($min == 0
          ? sfConfig::get('app_base_search')
          : sfConfig::get('app_more_search')),
      'start'  => $min,
      'market' => $culture
      ));

    $response = json_decode($response);

    if ($response && $response->bossresponse->responsecode == '200')
    {
      foreach ($response->bossresponse->web->results as $result)
      {
        $this->search_results[] = array(
          'title'      => $result->title,
          'content'    => $result->abstract,
          'clickUrl'   => $result->clickurl,
          'displayUrl' => $result->dispurl,
        );
      }
    }
  }

  private function executeNews($min = 0)
  {
    $auth = new up2gYahooOAuth(sfConfig::get('app_oauth_key'), sfConfig::get('app_oauth_secret'));

    $culture = sfContext::getInstance()->getUser()->getCulture() == 'en'
        ? 'en-us'
        : 'fr-fr';

    $response = $auth->call(sfConfig::get('app_url_engine_news'), array(
      'q'      => $this->search_text,
      'format' => 'json',
      'count'  => ($min == 0
          ? sfConfig::get('app_base_search')
          : sfConfig::get('app_more_search')),
      'start'  => $min,
      'market' => $culture,
      'age'    => '7d',
      'sort'   => 'date',
      ));

    $response = json_decode($response);

    if ($response && $response->bossresponse->responsecode == '200')
    {
      foreach ($response->bossresponse->news->results as $result)
      {
        $this->search_results[] = array(
          'title'     => $result->title,
          'content'   => $result->abstract,
          'clickUrl'  => $result->clickurl,
          'source'    => $result->source,
          'sourceUrl' => $result->sourceurl,
          'date'      => date('d/m/Y', $result->date),
          'time'      => date('H:m:s', $result->date),
        );
      }
    }
  }

  public function getPubResults($nombre = 2, $min = 0)
  {
    $env = sfContext::getInstance()->getConfiguration()->getEnvironment();
    $nombre += $min;

    $url = sfConfig::get('app_ddc_hostname') . sfConfig::get('app_ddc_path');

    $parameters = array(
      'n'    => $nombre,
      'kw'   => urlencode($this->search_text),
      'cb'   => uniqid(),
      'c'    => sfConfig::get('app_ddc_id'),
      'surl' => 'http://up2green.com/',
      'ua'   => $_SERVER['HTTP_USER_AGENT'],
      'ip'   => ($env !== 'dev')
          ? $_SERVER['REMOTE_ADDR']
          : '92.243.6.168',
    );

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $parameters['xfip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    $dom = new DomDocument();
    $dom->load($url.'?'.http_build_query($parameters));

    $results = array();
    $i = 0;

    foreach ($dom->getElementsByTagName("ad") as $result)
    {
      if ($i < $min)
      {
        $i++;
        continue;
      }
      $results[] = array(
        'title'       => $result->getElementsByTagName('title')->item(0)->nodeValue,
        'description' => $result->getElementsByTagName('description')->item(0)->nodeValue,
        'url'         => $result->getElementsByTagName('url')->item(0)->nodeValue,
        'visibleurl'  => $result->getElementsByTagName('url')->item(0)->getAttribute('visibleurl'),
      );
    }

    return $results;
  }

  private function executeShop($min = 0)
  {

    $results = Doctrine::getTable('engine')->getArraySearch(
      $this->search_text, $min == 0
          ? sfConfig::get('app_base_search')
          : sfConfig::get('app_more_search'), $min
    );

    foreach ($results as $id => $result)
    {
      $results[$id] = $this->processShopResult($result);
    }

    $this->search_results = $results;
  }

  private function processShopResult(&$result)
  {
    $result = array_map('trim', $result);
    $result = array_map(array('SearchEngine', 'addUrlId'), $result);

    $linkOpen = '<a target="_blank" href="' . $result['site_url'] . '">';

    if (substr($result['logo'], 0, 7) === 'http://')
    {
      $result['logo'] = $linkOpen . '<img src="' . $result['logo'] . '" alt="' . $result['site_display'] . '" /></a>';
    }
    elseif (substr($result['logo'], 0, 3) === '<a ')
    {
      $result['logo'] = '<a target="_blank" ' . substr($result['logo'], 3);
    }

    if (empty($result['html']))
    {
      $result['html'] = '
				<h3>' . $linkOpen . $result['site_display'] . '</a></h3>
				<p>' . $result['description'] . '</p>
			';
    }

    $result = array_map('htmlspecialchars', $result);
    return $result;
  }

  private static function addUrlId($value)
  {
    $idUser = sfContext::getInstance()->getUser()->isAuthenticated()
        ? sfContext::getInstance()->getUser()->getGuardUser()->getId()
        : Doctrine::getTable('sfGuardUser')->getUp2greenId();

    if (preg_match('/{up2greenID}/', $value))
    {
      return str_replace('{up2greenID}', $idUser, $value);
    }
    else
    {
      $pattern = '/(http:\/\/[^\'"]*)/';
      return preg_replace($pattern, '$1' . '&up2greenID=' . $idUser, $value);
    }
  }

  public static function cleanText($str, $charset = 'utf-8')
  {
    $str = str_replace("'", " ", $str);
    $str = up2gTools::removeAccents($str);

    return $str;
  }
}