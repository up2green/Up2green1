<div class="result">
    <h3 class="tooltip">
		<a target="_blank" href="<?php echo $result['url'] ?>">
			<?php echo html_entity_decode($result['title']) ?>
		</a>
		<span class="tooltip-content classic">
		<?php
		echo __("Grâce à ce lien sponsorisé gagnez des crédits arbres.");
		?>
		</span>
	</h3>

	<?php if ($result['description'] != "") : ?>
    <p class="content"><?php echo html_entity_decode($result['description']) ?></p>
    <?php endif; ?>

    <h4 class="tooltip">
		<?php echo __("Source : {link}", array(
			'{link}' => '<a target="_blank" href="'.$result['url'].'">'.$result['visibleurl'].'</a>'
		)); ?>
		<span class="tooltip-content classic">
		<?php 
		echo __("Grâce à ce lien sponsorisé gagnez des crédits arbres.");
		?>
		</span>
	</h4>

</div>
