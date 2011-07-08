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
if(isset($displayProgrammePartenaire)) {
	$kmlURL .= '&displayProgrammePartenaire='.$displayProgrammePartenaire;
}
if(isset($displayOrganismeActif)) {
	$kmlURL .= '&displayOrganismeActif='.$displayOrganismeActif;
}
if(isset($displayOrganismeInactif)) {
	$kmlURL .= '&displayOrganismeInactif='.$displayOrganismeInactif;
}
if(isset($displayProgrammeActif)) {
	$kmlURL .= '&displayProgrammeActif='.$displayProgrammeActif;
}
if(isset($displayProgrammePartenaire)) {
	$kmlURL .= '&displayProgrammeInactif='.$displayProgrammeInactif;
}

?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false&language=<?php echo $sf_user->getCulture(); ?>"></script>
<script type="text/javascript" src="https://www.google.com/jsapi?key=<?php echo $gmapID; ?>"></script>
<script type="text/javascript" src="/js/googleearth.js"></script>
<script type="text/javascript" src="/js/google.maps.extras.js"></script>

<script type="text/javascript">
	
	google.load("earth", "1");
	
	$(document).ready(function(){
				
		var myOptions = {
			zoom: 2,
			center: new google.maps.LatLng(0,0),
			mapTypeId: google.maps.MapTypeId.HYBRID
		};
		
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		
		ctaLayer = new google.maps.KmlLayer("<?php echo $kmlURL; ?>", {preserveViewport:true});
		ctaLayer.setMap(map);
		
		infowindow = new google.maps.InfoWindow();
		infowindow.close();
		infowindow.setOptions({maxWidth:400});
		
		
		google.maps.event.addListener(ctaLayer, 'click', function(kmlEvent) {
			var programmeRegexp = new RegExp(/gmap-programme-/);
			var organismeRegexp = new RegExp(/gmap-organisme-/);
			if(programmeRegexp.test(kmlEvent.featureData.id)) {
				$.ajax({
					url: "<?php echo url_for("ajax/getInfoProgramme", true) ?>",
					context: kmlEvent,
					async: false,
					dataType: "xml",
					data: {
						programme: kmlEvent.featureData.id.substring(15),
						canPlant: <?php echo (isset($canPlant) && $canPlant) ? 1 : 0 ?>
					},
					success: function(xml){
						currentKmlEvent = this;
						this.featureData.description = $(xml).find('text').text();
						applyTabsTimer = setInterval(applyTabs, 50);
					}
				});
			}
			else if(organismeRegexp.test(kmlEvent.featureData.id)) {
				$.ajax({
					url: "<?php echo substr(url_for("@get_info_organisme"), 1) ?>",
					context: kmlEvent,
					async: false,
					dataType: "xml",
					data: {
						organisme: kmlEvent.featureData.id.substring(15)
					},
					success: function(xml){
						this.featureData.description = $(xml).find('text').text();
					}
				});
			}
		});
		
		function applyTabs() {
			if($(".gmap-tabs-wrapper", $("#map_canvas")).length) {
				clearInterval(applyTabsTimer);
				$(".gmap-tabs-wrapper", $("#map_canvas")).tabs();
			}
		}
		
//		googleEarth = new GoogleEarth(map);
//		
//		googleEarthCBInit = function() {
//			var ge = googleEarth.getInstance();
//			
//			// disable some layers for faster load & run ... or not
//			var layerRoot = ge.getLayerRoot();
//	
//			layerRoot.enableLayerById(ge.LAYER_BORDERS, true); 
//			layerRoot.enableLayerById(ge.LAYER_BUILDINGS, true);
//			layerRoot.enableLayerById(ge.LAYER_BUILDINGS_LOW_RESOLUTION, true);
//			layerRoot.enableLayerById(ge.LAYER_ROADS, true);
//			layerRoot.enableLayerById(ge.LAYER_TERRAIN, true);
//			layerRoot.enableLayerById(ge.LAYER_TREES, true);
//			
//			ge.getSun().setVisibility(true);
//			ge.getOptions().setAtmosphereVisibility(true);
//			
//			var placemarks = ge.getElementsByType('KmlPlacemark');
//			for (var i = 0; i < placemarks.getLength(); ++i) {
//				var placemark = placemarks.item(i);
//				console.log(placemark.getId());
//			}
//			
//			google.earth.addEventListener(ge.getWindow(), 'mousedown', function(event){
//				var programmeRegexp = new RegExp(/gmap-programme-/);
//				currentPlacemark = event.getTarget();
//				
//				if (currentPlacemark.getType() == 'KmlPlacemark' && programmeRegexp.test(currentPlacemark.getId())) {
//					$.ajax({
//						url: "<?php echo substr(url_for("@get_info_programme"), 1) ?>",
//						async: false,
//						data: {
//							programme: currentPlacemark.getId().substring(15)
//						},
//						dataType: "xml",
//						success: function(xml){
//							var myText = $(xml).find('text').text();
//							// console.log(myText);
//							// @TODO : fix this bug.
////							currentPlacemark.setDescription($(xml).find('text').text());
//								applyTabsTimer = setInterval(applyTabs, 50);
//						}
//					});
//				}
//			});
//		};
		
	});
	
</script>

<div id="map_canvas" style="width: 700px; height: 450px;"></div>

<table id="gmap-legend">
	<tr>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-plantation-vert.gif" alt="<?php echo __("Programmes actifs") ?>"/></td>
		<td class="label"><?php echo __("Programmes actifs") ?></td>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-organisme-violet.gif" alt="<?php echo __("Siège des organismes actifs") ?>"/></td>
		<td class="label"><?php echo __("Organismes actifs") ?></td>
	</tr>
	<tr>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-plantation-gris.gif" alt="<?php echo __("Programmes inactifs") ?>"/></td>
		<td class="label"><?php echo __("Programmes inactifs") ?></td>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-organisme-gris.gif" alt="<?php echo __("Siège des organismes inactifs") ?>"/></td>
		<td class="label"><?php echo __("Organismes inactifs") ?></td>
	</tr>
	<?php if(isset($partenaire)) : ?>
	<tr>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-plantation-violet.gif" alt="<?php echo __("Programmes soutenus par le partenaire {partner}", array(
				'{partner}' => $partenaire->getTitle()
		)) ?>"/></td>
		<td class="label"><?php echo __("Programmes soutenus par le partenaire {partner}", array(
				'{partner}' => $partenaire->getTitle()
		)) ?></td>
	</tr>
	<?php endif; ?>
</table>
