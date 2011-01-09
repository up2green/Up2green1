<pubResult>
	<title><?php echo html_entity_decode($result['title']) ?></title>
	<url><?php echo $result['url'] ?></url>
	<description><?php echo html_entity_decode($result['description']) ?></description>
	<source>
		<?php echo htmlentities(__("Source : {link}", array(
			'{link}' => '<a target="_blank" href="'.$result['url'].'">'.$result['visibleurl'].'</a>'
		))); ?>
	</source>
	
</pubResult>