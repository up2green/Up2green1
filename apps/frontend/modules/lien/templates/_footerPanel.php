<?php foreach($footerCategories as $footerCategorie) : ?>
<ul>
	<?php foreach($footerCategorie->GetActiveLiens() as $lien) : ?>
	<li><a target="_blank" href="<?php echo $lien->getSrc() ?>"><?php echo $lien->getTitle(); ?></a></li>
	<?php endforeach; ?>
</ul>
<?php endforeach; ?>