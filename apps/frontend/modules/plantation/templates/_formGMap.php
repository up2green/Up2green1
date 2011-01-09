<!-- module -->
<div id="gmapWrapper" class="module">
	<img class="title corner left" src="/images/module/green/icon/program.png" alt="" />
	<p class="title"><?php echo __("Les programmes de reforestation que nous soutenons") ?></p>
	<div class="content">
	
		<?php if(!empty($gMapModes)) : ?>
		<script type="text/javascript">
			var gMapModes = <?php echo json_encode($gMapModes); ?>;
		</script>
		<?php endif; ?>
		
		<?php use_helper('Javascript','GMap') ?>
		<?php include_map($gMap,array('width'=>'700px','height'=>'450px')); ?>
		<?php include_map_javascript($gMap); ?>
		
		<?php if(!empty($gMapModes)) : ?>
		<div class="modeSelector">
			<ul>
				<?php 
				
				foreach($gMapModes as $gMapMode) :

					$gMapModesLabels = array(
						'user' => __("Les arbres plantés avec mon compte"),
						'coupon' => __("Les arbres plantés avec mes coupons"),
						'all' => __("Tous les arbres plantés"),
						
					);

				if(isset($gMapMode['partenaireTitle']) && isset($gMapMode['partenaireId'])) {
					$gMapModesLabels += array(
						'partenaire-'.$gMapMode['partenaireId'] => __("Tous les arbes plantés par {partenaire}", array(
							'partenaire' => $gMapMode['partenaireTitle']
						))
					);
				}
				
				?>
				<li>
					<input type='radio' class="gMapMode" name="gMapMode" value="<?php echo $gMapMode['name'] ?>" id="gMapMode_<?php echo $gMapMode['name'] ?>"<?php echo ($gMapMode['checked']) ? ' checked="checked"' : '' ?>>
					<label for="gMapMode_<?php echo $gMapMode['name'] ?>" ><?php echo $gMapModesLabels[$gMapMode['name']] ?></label>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="clear"></div>
		<?php endif; ?>
		
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
