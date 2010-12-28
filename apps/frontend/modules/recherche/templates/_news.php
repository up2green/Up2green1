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
    
    <h4>
		<?php

		echo __("Source : {link}", array(
			'{lien}' => '<a target="_blank" href="'.html_entity_decode($result['sourceUrl']).'">'.html_entity_decode($result['source']).'</a>'
		));
		
		echo '
			<span class="filename">[
			'.__("le {date} à {time}", array(
				'{date}' => html_entity_decode($result['date']),
				'{time}' => html_entity_decode($result['time']),
			)).'
			]</span>
		';

		?>
	</h4>
	
</div>
