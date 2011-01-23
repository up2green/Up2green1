<div class="result">
    <h3>
		<a target="_blank" href="<?php echo $result['url'] ?>">
			<?php echo html_entity_decode($result['title']) ?>
		</a>
	</h3>

	<?php if ($result['description'] != "") : ?>
    <p class="content"><?php echo html_entity_decode($result['description']) ?></p>
    <?php endif; ?>

    <h4>
		<?php echo __("Source : {link}", array(
			'{link}' => '<a target="_blank" href="'.$result['url'].'">'.$result['visibleurl'].'</a>'
		)); ?>
	</h4>

</div>
