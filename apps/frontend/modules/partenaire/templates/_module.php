<div class="module<?php echo (isset ($moduleClass) ? ' '.$moduleClass : '') ?>" style="width:<?php echo isset($width) ? $width : 'auto'; ?>">
	
	<?php if (isset ($displayIcon) && $displayIcon) : ?>
	<img class="title middle left" src="/images/module/purple/icon/icon-partenaires.png" alt="" />
	<?php endif?>

	<?php if (isset ($displayTitle) && $displayTitle) : ?>
	<p class="title indent">
		<?php if ($partenaire->getUrl()) : ?>
		<a target="_blank" href="<?php echo $partenaire->getUrl(); ?>">
		<?php endif; ?>
		
		<?php echo $partenaire->getTitle() ?>
		
		<?php if ($partenaire->getUrl()) : ?>
		</a>
		<?php endif; ?>
    </p>
	<?php endif; ?>

	<div class="content">

		<?php include_partial('partenaire/logos', array('partenaire' => $partenaire)); ?>

		<?php if ($partenaire->getUrl()) : ?>
		<a class="light" target="_blank" href="<?php echo $partenaire->getUrl(); ?>">
		<?php endif; ?>

		<p><?php echo $partenaire->getAccroche(); ?></p>

		<?php if ($partenaire->getUrl()) : ?>
		</a>
		<?php endif; ?>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
