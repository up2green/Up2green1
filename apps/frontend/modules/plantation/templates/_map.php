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