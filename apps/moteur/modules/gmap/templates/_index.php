<div class="module">
	<div class="head"></div>
	<div class="body_wrapper">
		<div class="body_inner">
			<?php use_helper('Javascript','GMap') ?>
			<?php include_map($gMap,array('width'=>'700px','height'=>'450px')); ?>
			<?php include_map_javascript($gMap); ?>
		</div>
	</div>
	<div class="foot"></div>
</div>
