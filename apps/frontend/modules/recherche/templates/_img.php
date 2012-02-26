<div class="result">
	<a target="_blank" href="<?php echo html_entity_decode($result['clickUrl'])?>">
		<img src="<?php echo $result['thumbnail'] ?>" />
    </a>
    <?php if ($result['content'] != "") : ?>
	<p class="content">
		<?php echo html_entity_decode($result['content']) ?>
	</p>
	<?php endif; ?>
    <a target="_blank" href="<?php echo html_entity_decode($result['clickUrl'])?>">
		<?php echo $result['displayUrl'] ?>
	</a>
	<span class="filename">[<?php echo $result['title'] ?>]</span>
</div>
