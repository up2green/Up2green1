<!-- module -->
<div id="gmapWrapper" class="module">
	<img class="title corner left" src="/images/module/green/icon/program.png" alt="" />
	<p class="title">Les programmes de reforestation que nous soutenons</p>
	<div class="content">
	
		<?php if(!empty($gMapModes)) : ?>
		<script type="text/javascript">
			var gMapModes = <?php echo json_encode($gMapModes->getRawValue()); ?>
		</script>
		<?php endif; ?>
		
		<?php use_helper('Javascript','GMap') ?>
		<?php include_map($gMap,array('width'=>'700px','height'=>'450px')); ?>
		<?php include_map_javascript($gMap); ?>
		
		<?php if(!empty($gMapModes)) : ?>
		<div class="modeSelector">
			<ul>
				<?php foreach($gMapModes as $gMapMode) : ?>
				<li>
					<input type='radio' class="gMapMode" name="gMapMode" value="<?php echo $gMapMode['name'] ?>" id="gMapMode_<?php echo $gMapMode['name'] ?>"<?php echo ($gMapMode['selected']) ? ' selected="selected"' : '' ?>>
					<label for="gMapMode_<?php echo $gMapMode['name'] ?>" ><?php echo $gMapMode['label'] ?></label>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
		
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
