<div class="result">
    <h3>
		<a target="_blank" href="<?php echo html_entity_decode($result['clickUrl'])?>">
			<?php echo html_entity_decode($result['title']) ?>
		</a>
	</h3>
    
    <?php if ($result['content'] != "") : ?>
    <p class="content">
    <?php echo html_entity_decode($result['content']) ?>
    </p>
    <?php endif; ?>
    
    <a target="_blank" href="<?php echo html_entity_decode($result['clickUrl'])?>">
		<?php echo html_entity_decode($result['displayUrl']) ?>
	</a>
</div>
