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
			<?php if(!empty($url)) : ?><a target="_blank" href="<?php echo $url; ?>"><?php endif; ?>
			<?php if($partenaire->getLogo() != '') : ?>
			<img class="organisme-image" src="/uploads/partenaire/<?php echo $partenaire->getLogo(); ?>" alt="Logo">
			<?php endif; ?>
			<p><?php echo $partenaire->getAccroche(); ?></p>
			<?php if(!empty($url)) : ?></a><?php endif; ?>
    </div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
