<?php

/**
 * gmap actions.
 *
 * @package    up2green
 * @subpackage gmap
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gmapActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->gMap = new GMap();
    $this->gMap->addMarker(new GMapMarker(51.245475,6.821373));
    $this->gMap->addMarker(new GMapMarker(46.262248,6.115969));
    $this->gMap->centerAndZoomOnMarkers();
  }
  
}
