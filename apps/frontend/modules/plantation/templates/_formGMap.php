<p style="text-align:center;padding: 15px 5px; "><?php echo __("Visualisez les enjeux de chaque programme de reforestation en cliquant sur les info-bulles."); ?></p>

<?php 

//$url = "&up_kml_url=".sfConfig::get('app_url_moteur').substr(url_for("@get_kml"), 1);
//$url .= "&up_view_mode=earth";
//$url .= "&up_earth_2d_fallback=1";
//$url .= "&up_earth_fly_from_space=1";
//$url .= "&up_earth_show_nav_controls=1";
//$url .= "&up_earth_show_buildings=1";
//$url .= "&up_earth_show_terrain=1";
//$url .= "&up_earth_show_roads=1";
//$url .= "&up_earth_show_borders=1";
//$url .= "&up_earth_sphere=earth";
//$url .= "&up_maps_zoom_out=1";
//$url .= "&up_maps_default_type=terrain";
//$url .= "&synd=open";
//$url .= "&w=700";
//$url .= "&h=450";
//$url .= "&border=none";
//$url .= "&output=js";
//
//$url = htmlentities($url);
//$url = str_replace("/", "%2F", $url);
//$url = str_replace(":", "%3A", $url);

?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false&language=<?php echo $sf_user->getCulture(); ?>"></script>

<script type="text/javascript">
	function initialize() {
		var myLatlng = new google.maps.LatLng(0,0);
		var myOptions = {
			zoom: 1,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.TERRAIN
		}

		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

		var ctaLayer = new google.maps.KmlLayer("<?php echo sfConfig::get('app_url_moteur').substr(url_for("@get_kml"), 1).'?key='.uniqid(); ?>", {preserveViewport:true});
		ctaLayer.setMap(map);
		
	}
	
	$(document).ready(function(){
		initialize();
	});
</script>

<div id="map_canvas" style="width: 700px; height: 450px;"></div>