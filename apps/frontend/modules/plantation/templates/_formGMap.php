<?php if(!empty($gMapModes)) : ?>
<script type="text/javascript">
	var gMapModes = <?php echo json_encode($gMapModes); ?>;
</script>
<?php endif; ?>

<p style="text-align:center;padding: 15px 5px; "><?php echo __("Visualisez les enjeux de chaque programme de reforestation en cliquant sur les info-bulles."); ?></p>

<?php 

$url = "&up_kml_url=".sfConfig::get('app_url_moteur').substr(url_for("@get_kml"), 1);
$url .= "&up_view_mode=earth";
$url .= "&up_earth_2d_fallback=1";
$url .= "&up_earth_fly_from_space=1";
$url .= "&up_earth_show_nav_controls=1";
$url .= "&up_earth_show_buildings=1";
$url .= "&up_earth_show_terrain=1";
$url .= "&up_earth_show_roads=1";
$url .= "&up_earth_show_borders=1";
$url .= "&up_earth_sphere=earth";
$url .= "&up_maps_zoom_out=1";
$url .= "&up_maps_default_type=terrain";
$url .= "&synd=open";
$url .= "&w=700";
$url .= "&h=450";
$url .= "&border=none";
$url .= "&output=js";

$url = htmlentities($url);
$url = str_replace("/", "%2F", $url);
$url = str_replace(":", "%3A", $url);

?>

<script src="http://www.gmodules.com/ig/ifr?url=http://code.google.com/apis/kml/embed/embedkmlgadget.xml<?php echo $url; ?>"></script>

<?php if(!empty($gMapModes)) : ?>
<div class="modeSelector">
	<ul>
		<?php

		foreach($gMapModes as $gMapMode) :

			$gMapModesLabels = array(
				'user' => __("Ma forêt – mes arbres : {nbArbres}", array('{nbArbres}' => $gMapMode['displayValue'])),
				'coupon' => __("Les arbres plantés avec mes coupons : {nbArbres}", array('{nbArbres}' => $gMapMode['displayValue'])),
				'all' => __("Tous les arbres plantés : {nbArbres}", array('{nbArbres}' => $gMapMode['displayValue'])),
			);

			if(isset($gMapMode['partenaireTitle']) && isset($gMapMode['partenaireId'])) {
				$gMapModesLabels += array(
					'partenaire-'.$gMapMode['partenaireId'] => __("Tous les arbes plantés par {partenaire} : {nbArbres}", array(
						'{partenaire}' => $gMapMode['partenaireTitle'],
						'{nbArbres}' => $gMapMode['displayValue']
					))
				);
			}

		?>
		<li>
			<input type='radio' class="gMapMode" name="gMapMode" value="<?php echo $gMapMode['name'] ?>" id="gMapMode_<?php echo $gMapMode['name'] ?>"<?php echo ($gMapMode['checked']) ? ' checked="checked"' : '' ?>>
			<label for="gMapMode_<?php echo $gMapMode['name'] ?>" style="position:relative;">
				<?php echo $gMapModesLabels[$gMapMode['name']] ?>
				<?php if($gMapMode['name'] === 'all') : ?>
				<img title="<?php echo __("Déjà 6749 arbres plantés en 2009/2010 avec Trees for the Future, Planète Urgence et l'ONF en France, Ethiopie, Inde, Haïti, Burundi, Brésil, Honduras, Mali et Indonésie.") ?>" src="/images/icons/16x16/consulting.png">
				<?php endif; ?>
			</label>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
