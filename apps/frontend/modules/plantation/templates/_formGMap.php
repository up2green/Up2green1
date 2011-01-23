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

		<h3 style="padding: 5px; text-align: center;"><?php echo __("En 2010/2011") ?></h3>
		
		<?php use_helper('Javascript','GMap') ?>
		<?php include_map($gMap,array('width'=>'700px','height'=>'450px')); ?>
		<?php include_map_javascript($gMap); ?>
		
		<?php if(!empty($gMapModes)) : ?>
		<div class="modeSelector">
			<ul>
				<?php 
				
				foreach($gMapModes as $gMapMode) :

					$gMapModesLabels = array(
						'user' => __("Ma forêt – mes arbres : {nbArbres}", array('{nbArbres}' => $gMapMode['displayValue'])),
						'coupon' => __("Les arbres plantés avec mes coupons : {nbArbres}", array('{nbArbres}' => $gMapMode['displayValue'])),
						'all' => __("Tous les arbres plantés : {nbArbres}", array('{nbArbres}' => $gMapMode['displayValue'])),
						
					);

					if(isset($gMapMode['partenaireTitle']) && isset($gMapMode['partenaireId'])) {
						$gMapModesLabels += array(
							'partenaire-'.$gMapMode['partenaireId'] => __("Tous les arbes plantés par {partenaire} : {nbArbres}", array(
								'{partenaire}' => $gMapMode['partenaireTitle'],
								'{nbArbres}' => $gMapMode['displayValue']
							))
						);
					}
				
				?>
				<li>
					<input type='radio' class="gMapMode" name="gMapMode" value="<?php echo $gMapMode['name'] ?>" id="gMapMode_<?php echo $gMapMode['name'] ?>"<?php echo ($gMapMode['checked']) ? ' checked="checked"' : '' ?>>
					<label for="gMapMode_<?php echo $gMapMode['name'] ?>" <?php echo $gMapMode['name'] === 'all' ? 'class="tooltip"' : '' ?> style="position:relative;">
						<?php echo $gMapModesLabels[$gMapMode['name']] ?>
						<?php if($gMapMode['name'] === 'all') : ?>
						<img src="/images/icons/16x16/consulting.png" class="auto-tooltip-icon" style="top: 0;">
						<span class="tooltip-content classic" style="padding:10px;width:250px;">
							<?php echo __("Déjà 6749 arbres plantés en 2009/2010 avec Trees for the Future, Planète Urgence et l'ONF en France, Ethiopie, Inde, Haïti, Burundi, Brésil, Honduras, Mali et Indonésie.") ?>
						</span>
						<?php endif; ?>
					</label>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="clear"></div>
		<?php endif; ?>
		
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
