<div id="form_programme_plantation" class="module">
	<?php if($show_programme_navigation) : ?>
	<span id="slideUp" class="button white">Haut</span>
	<?php endif; ?>
	
	<ul>
		<?php foreach($programmes as $programme) : ?>
		<li><?php echo $programme->getTitle(); ?></li>
		<?php endforeach; ?>
	</ul>
	
	<?php if($show_programme_navigation) : ?>
	<span id="slideDown" class="button white">Bas</span>
	<?php endif; ?>
	
</div>
