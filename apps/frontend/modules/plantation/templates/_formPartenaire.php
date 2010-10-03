<?php 
	$url = $partenaire->getUrl();
	
?>

<div class="module purple">
    <img class="title middle left" src="/images/module/purple/icon/icon-partenaires.png" alt="" />
    <p class="title indent">
    	<?php if(!empty($url)) : ?><a target="_blank" href="<?php echo $url; ?>"><?php endif; ?>
    	<?php echo $partenaire->getTitle() ?>
    	<?php if(!empty($url)) : ?></a><?php endif; ?>
    </p>
    <div class="content">
    	<?php if(!empty($url)) : ?>
    	<a target="_blank" href="<?php echo $url; ?>">
    	<?php endif; ?>
	<?php
	if(
	$partenaire->getLogo() != '' &&
		file_exists(sfConfig::get('sf_upload_dir').'/partenaire/'.$partenaire->getLogo())
	) :
	    ?>
	<img class="organisme-image" src="/uploads/partenaire/<?php echo $partenaire->getLogo(); ?>" alt="Logo">
	<?php endif; ?>
	<p><?php echo $partenaire->getAccroche(); ?></p>
	<p class="center">
		<?php
		if($sf_user->isAuthenticated() && !is_null($partenaire)) {
			if($view === 'listeCouponsPartenaires') {
				echo '<a href="/" class="button green">Retour à la Carte</a>';
			}
			else {
				echo '<a href="' . url_for('@plantation_liste_coupon_partenaire') . '" class="button purple">Voir mes coupons</a>';
			}
		}
		?>
	</p>
		</a>
    </div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
