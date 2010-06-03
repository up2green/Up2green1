<?php

/**
 * gmap actions.
 *
 * @package    up2green
 * @subpackage gmap
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gmapComponents extends sfComponents
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    
  public function executeIndex(sfWebRequest $request)
  {
    $this->gMap = new GMap();
    $this->programmes = Doctrine::getTable('programme')->createQuery('a')->execute();
    foreach($this->programmes as $programme)
    {
    	if(!is_null($programme->getLatitude()) && !is_null($programme->getLongitude()))
    	{
    		$icon = new GMapMarkerImage(
			  'images/gmap/tree.png',
			  array(
				'width' => 32,
				'height' => 32,
			  )
			);
			
			$gMapMarker = new GMapMarker(
				$programme->getLatitude(),
				$programme->getLongitude(),
				array(
					'icon'	=> $icon
				)
/*
				array(
					'title ' => $programme->getTitle(),
					'icon ' => null,
					'zIndex ' => (100 + floor($programme->getMaxTree()/1000)),
					'cursor ' => null, // string  Mouse cursor to show on hover  
					'clickable ' => null,
					'shadow ' => null,
					'flat ' => null
				)
*/
			);
		
			$gMapMarker->addHtmlInfoWindow(new GMapInfoWindow('<div>'.$programme->getTitle().'</div>'));
			$this->gMap->addMarker($gMapMarker);

		}
	}
    $this->gMap->centerAndZoomOnMarkers();
  }
  
  private function getProgrammeIcon(programme $programme)
  {
  	$image = new GMapMarkerImage(
  		'/images/gmap/tree.png',
  		array('width' => '32px','height' => '32px')
  	);
  	
  	return $image;
  }
  
}
