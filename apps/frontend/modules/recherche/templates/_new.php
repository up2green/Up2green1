<div class="result">
    <h3>
		<a href="<?php echo html_entity_decode($result['clickUrl'])?>">
			<?php echo html_entity_decode($result['title']) ?>
		</a>
	</h3>
	
	<?php if ($result['content'] != "") : ?>
    <p class="content">
    <?php echo html_entity_decode($result['content']) ?>
    </p>
    <?php endif; ?>
    
    <h4>
		Source : 
		<a href="<?php echo html_entity_decode($result['sourceUrl'])?>">
			<?php echo html_entity_decode($result['source']) ?>
		</a>
		<span class="filename">
			[le <?php echo html_entity_decode($result['date']) ?> à <?php echo html_entity_decode($result['time']) ?>]
		</span>
	</h4>
	
</div>
