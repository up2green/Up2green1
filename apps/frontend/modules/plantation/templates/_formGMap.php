<p style="text-align:center;padding: 15px 5px; ">
  <?php echo __("Visualisez les enjeux de chaque programme de reforestation en cliquant sur les info-bulles."); ?>
</p>

<?php include_component("plantation", "map", array(
    'partenaire' => isset($partenaire) ? $partenaire : null
)); ?>

<?php include_component("plantation", "mapLegend", array(
    'partenaire' => isset($partenaire) ? $partenaire : null
)); ?>