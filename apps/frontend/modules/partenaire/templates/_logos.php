<ul class="partenaire-logo-list">
	<?php foreach ($partenaire->getLogos() as $logo) : ?>
	<li class="partenaire-logo">
		<a href="<?php echo $logo->getHref() ?>">
			<img class="organisme-image" src="<?php echo $logo->getPath() ?>" alt="Logo" />
		</a>
	</li>
	<?php endforeach; ?>
</ul>
