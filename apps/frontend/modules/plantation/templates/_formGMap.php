<p style="text-align:center;padding: 15px 5px; ">
  <?php echo __("Visualisez les enjeux de chaque programme de reforestation en cliquant sur les info-bulles."); ?>
</p>

<?php include_component("plantation", "map", array(
    'partenaire' => isset($partenaire) ? $partenaire : null
)); ?>

<?php 

if (isset ($partenaire) && !empty ($partenaire)) { 
	if ($partenaire->getPageTitle() != '') {
		echo link_to($partenaire->getPageTitle(), 'landing/pagePartenaire?partenaire='.$partenaire->getUser()->getUsername(), array('class' => 'partenaire-page-link'));
	}
}
else {
	include_component("plantation", "mapLegend");
} 

?>
