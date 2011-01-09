<div class="result">
    <h3 class="tooltip">
		<a target="_blank" href="<?php echo $result['url'] ?>">
			<?php echo html_entity_decode($result['title']) ?>
		</a>
		<span class="tooltip-content classic">
		<?php
		echo __("Grâce à ce lien sponsorisé gagnez {gain}.", array(
			'{gain}' => sfConfig::get('app_gain_cpc').'<img src="/images/icons/16x16/arbre.png" alt="Arbre(s)" />')
		);
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
		echo __("Grâce à ce lien sponsorisé gagnez {gain}.", array(
			'{gain}' => sfConfig::get('app_gain_cpc').'<img src="/images/icons/16x16/arbre.png" alt="Arbre(s)" />')
		);
		?>
		</span>
	</h4>

</div>
