<div id="form_programme_plantation" class="module">
	<div class="head"></div>
	<div class="body_wrapper">
		<div class="body_inner">
			<?php if($show_programme_navigation) : ?>
			<span id="slideUp" class="button white">
				<img src="images/icons/top.png" alt="Haut"/>
			</span>
			<?php endif; ?>
			
			<ul>
				<?php foreach($programmes as $programme) : ?>
				<li><?php echo $programme->getTitle(); ?></li>
				<?php endforeach; ?>
			</ul>
			
			<?php if($show_programme_navigation) : ?>
			<span id="slideDown" class="button white">
				<img src="images/icons/bottom.png" alt="Bas"/>
			</span>
			<?php endif; ?>
		</div>
	</div>
	<div class="foot"></div>
</div>
