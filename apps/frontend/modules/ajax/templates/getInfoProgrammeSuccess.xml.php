<text><![CDATA[
<div class="gmap-info-programme-tabs-wrapper">
	<ul>
		<li><a href="#gmap-tabs-1-programme-<?php echo $programme->getId() ?>"><?php echo __("Info") ?></a></li>
		<?php if($programme->getOrganisme()) : ?>
		<li><a href="#gmap-tabs-2-programme-<?php echo $programme->getId() ?>"><?php echo __("Organisme") ?></a></li>
		<?php endif; ?>
	</ul>
	<div id="gmap-tabs-1-programme-<?php echo $programme->getId() ?>">
		<span style="display:block;padding-top:10px;" class="content">
			<?php if($programme->getLogo()) : ?>
			<img class="gmap-programme" src="/uploads/programme/<?php echo $programme->getLogo() ?>" alt="Diapo Image" />
			<?php endif; ?>
			<div class="accroche-programme"><?php echo $programme->getAccroche(); ?></div>
			<a href="<?php echo sfConfig::get('app_url_blog') ?>/programme/<?php echo $programme->getSlug() ?>" class="read_more" target="_blank">Lire la suite</a>
			<br />
		</span>
	</div>
	<?php if($programme->getOrganisme()) : ?>
	<div id="gmap-tabs-2-programme-<?php echo $programme->getId() ?>">
		organisme
	</div>
	<?php endif; ?>
</div>
]]></text>