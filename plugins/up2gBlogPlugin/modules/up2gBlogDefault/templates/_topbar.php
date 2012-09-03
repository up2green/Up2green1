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
    &nbsp;|&nbsp;
    <!-- AddThis Follow BEGIN -->
    <div class="addthis_toolbox addthis_32x32_style addthis_default_style" style="float: right; margin-top: 4px;">
      <strong><?php echo __("Suivez nos aventures !") ?></strong>
      <a class="addthis_button_facebook_follow" addthis:userid="Up2green"></a>
      <a class="addthis_button_twitter_follow" addthis:userid="up2green"></a>
    </div>
    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f5d372f3fb98941"></script>
    <!-- AddThis Follow END -->
	</div>
	<div class="tool_box">
		<div id="language-wrapper">
			<?php echo include_component('user', 'language'); ?>
		</div>
	</div>
</div>