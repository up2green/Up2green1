<?php
use_stylesheet('landingPlantation.css?v='.sfConfig::get('app_media_version'));
use_stylesheet('blog.css?v='.sfConfig::get('app_media_version'));
?>

<div id="content" style="width:1050px;">

<div id="title" class="module" style="width:94%">
	<div class="content">
		<?php if($partenaire->getPage() == '') : ?>
		<h1><?php echo __("Le partenaire {partner} n'a pas encore renseigné sa page personnalisée.", array(
				'{partner}' => $partenaire->getTitle()
		)); ?></h1>
		<?php else : ?>
		<?php echo $partenaire->getPage(); ?>
		<?php endif; ?>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
	
</div>
