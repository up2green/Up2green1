<!-- module -->
<div id="form_programme_plantation" class="module">
	<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	<p class="title little indent">Devenez acteur de la reforestation</p>
	<div class="content">
		<?php if($show_programme_navigation) : ?>
		<span id="slideUp" class="button white">
			<img src="images/icons/top.png" alt="Haut"/>
		</span>
		<?php endif; ?>
		
		<ul>
			<?php foreach($programmes as $programme) : ?>
			<li>
				<span class="item"><?php echo $programme->getTitle(); ?></span>
				<span class="action">
					<button class="button really-small green">+</button>
					<button class="button really-small green">-</button>
				</span>
			</li>
			<?php endforeach; ?>
		</ul>
		
		<?php if($show_programme_navigation) : ?>
		<span id="slideDown" class="button white">
			<img src="images/icons/bottom.png" alt="Bas"/>
		</span>
		<?php endif; ?>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
