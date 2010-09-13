<!-- module -->
<div class="module">
	<img class="title corner left" src="/images/module/green/icon/program.png" alt="" />
	<p class="title">Les programmes de reforestation que nous soutenons</p>
	<div class="content">
		<?php use_helper('Javascript','GMap') ?>
		<?php include_map($gMap,array('width'=>'700px','height'=>'450px')); ?>
		<?php include_map_javascript($gMap); ?>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
