<?php
if($isPartenaire = (isset($partenaire) && !empty($partenaire))) {
	$blocWidth = "20%";
	$contentWidth = "45%";

	$title = __("Déjà {number} arbres plantés avec {affiliate}", array(
		'{number}' => $nbArbres,
		'{affiliate}' => $partenaire->getTitle()
	));

	$contentTitle = __("Faites grandir la forêt de {affiliate} sur la planète !", array(
		'{affiliate}' => $partenaire->getTitle()
	));
}
else {
	$title = __("Devenez acteur de la reforestation en plantant vos arbres avec up2gren !");
	$contentTitle = __("Faites grandir les forêts des programmes que nous soutenons sur la planète en quelques clics.");

	$blocWidth = "45%";
	$contentWidth = "45%";
}

use_stylesheet('landingPlantation.css?v='.sfConfig::get('app_media_version'));
use_stylesheet('blog.css?v='.sfConfig::get('app_media_version'));

?>

<?php if ($isPartenaire && $partenaire->getId() == (int)sfConfig::get('app_sdf_id')) : ?>
<style>body{background: url("/images/marketing/SdF/backgroundSite.jpg") no-repeat fixed center center transparent;}</style>
<?php endif; ?>

<div id="content" style="width:1050px;">

<div id="title" class="module" style="width:94%">
	<div class="content">
		<h1><?php echo $title; ?></h1>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

<div id="content-left" style="width:25%;float:left;">
	<!-- module up2green -->
	<div class="module">
		<div class="content">
			<a target="_blank" href="<?php echo sfConfig::get('app_url_moteur') ?>">
				<img src="/images/logo/200x200/earth-hand.png" alt="up2green" style="position: relative; left: -10px;" />
			</a>
		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>

	<?php if($isPartenaire) : ?>
	<?php include_partial('partenaire/module', array(
		'partenaire' => $partenaire, 
	)); ?>
	<?php endif; ?>
</div>
<div id="content-inner" style="float: left; width: 73%;">
	<!-- module GMap-->
	<div id="gmapWrapper" class="module" style="position: relative; text-align: left; font-size: 13px; font-weight: bold; color: rgb(255, 255, 255);" >
		<div class="content">
			<?php include_partial('plantation/formGMap', array(
				'partenaire' => $partenaire
			)); ?>
		<p class="center">
			<?php echo __("Vous avez un coupon de plantation ? {link}", array(
				'{link}' => link_to(__("Cliquez ici"), '/landing/plantation/'.($isPartenaire ? $partenaire->getUser()->getUsername().($partenaire->getId() == sfConfig::get('app_vedif_id') ? '/special' : '') : ''), array('class'=> 'button green small'))
			)); ?>
		</p>
		<div class="clear"></div>
		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>
</div>
<div class="clear"></div>
</div>
