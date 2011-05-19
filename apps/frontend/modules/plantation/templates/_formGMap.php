<p style="text-align:center;padding: 15px 5px; "><?php echo __("Visualisez les enjeux de chaque programme de reforestation en cliquant sur les info-bulles."); ?></p>

<?php 

$gmapID = sfConfig::get('app_google_maps_api_keys');
$gmapID = $gmapID[$_SERVER['HTTP_HOST']];

$kmlURL = sfConfig::get('app_url_moteur');
$kmlURL .= substr(url_for("@get_kml"), 1);
$kmlURL .= '?key='.uniqid();

if(isset($partenaire)) {
	$kmlURL .= '&partenaire='.$partenaire->getId();
}

?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false&language=<?php echo $sf_user->getCulture(); ?>"></script>
<script type="text/javascript" src="https://www.google.com/jsapi?key=<?php echo $gmapID; ?>"></script>
<script type="text/javascript" src="/js/googleearth.js"></script>

<script type="text/javascript">
	
	google.load("earth", "1");
	
	function initialize() {
		
		var myOptions = {
			zoom: 1,
			center: new google.maps.LatLng(0,0),
			mapTypeId: google.maps.MapTypeId.HYBRID
		}

		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		var googleEarth = new GoogleEarth(map);

		var ctaLayer = new google.maps.KmlLayer("<?php echo $kmlURL; ?>", {preserveViewport:true});
		ctaLayer.setMap(map);
		
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);
	
</script>

<div id="map_canvas" style="width: 700px; height: 450px;"></div>