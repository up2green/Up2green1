<div id="topbar">
	<div class="deja_planter">
		<?php
		echo image_tag("icons/mini-tree_30x30.png").'
			<a href="'.sfConfig::get('app_url_moteur').'">
				'.__("Déjà {number} arbres plantés ensemble", array(
					'{number}' => '<strong>'.$totalTrees.'</strong>'
				)).'
			</a>
		';
		?>
	</div>
	<div class="tool_box">
		<div id="language-wrapper">
			<?php echo include_component('user', 'language'); ?>
		</div>
	</div>
</div>