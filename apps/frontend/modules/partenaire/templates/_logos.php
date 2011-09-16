<ul class="partenaire-logo-list">
	<?php foreach ($partenaire->getLogos() as $logo) : ?>
	<li class="partenaire-logo">
    <?php if (!isset ($withoutLink) || !$withoutLink) : ?>
		<a href="<?php echo $logo->getHref() ?>">
    <?php endif; ?>
			<img class="organisme-image" src="<?php echo $logo->getPath() ?>" alt="Logo" />
    <?php if (!isset ($withoutLink) || !$withoutLink) : ?>
		</a>
    <?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>
