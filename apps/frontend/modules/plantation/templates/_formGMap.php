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
<script type="text/javascript" src="/js/google.maps.extras.js"></script>

<script type="text/javascript">
	
	google.load("earth", "1");
	
	$(document).ready(function(){
		
		google.maps.Map.prototype.applyTabs = function() {
			for(var i=0; i < this.markers.length; i++){
					console.log(this.markers[i]);
			}
		};
		
		var myOptions = {
			zoom: 1,
			center: new google.maps.LatLng(0,0),
			mapTypeId: google.maps.MapTypeId.HYBRID
		}

		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		
		ctaLayer = new google.maps.KmlLayer("<?php echo $kmlURL; ?>", {preserveViewport:true});
		ctaLayer.setMap(map);
		
		google.maps.event.addListener(ctaLayer, 'click', function(kmlEvent) {
			var programmeRegexp = new RegExp(/gmap-programme-/);
			if(programmeRegexp.test(kmlEvent.featureData.id)) {
				$.ajax({
					url: "<?php echo substr(url_for("@get_info_programme"), 1) ?>",
					context: kmlEvent,
					async: false,
					data: {
						programme: kmlEvent.featureData.id.substring(15)
					},
					success: function(xml){
						this.featureData.description = $(xml).find('text').text();
						setTimeout(function(){
						 $('.gmap-info-programme-tabs-wrapper', "#map_canvas").tabs();
						},400);
					},
					error: function(jqXHR, textStatus, errorThrown){},
					dataType: "xml"
				});
			}
		});
		
		googleEarth = new GoogleEarth(map);

	});
	
</script>

<div id="map_canvas" style="width: 700px; height: 450px;"></div>