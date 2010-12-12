<div class="module grey">
	<div class="content center">
		<p class="title_blog"><?php echo $element->getTitle(); ?></p>
		<?php
		  if(isset($element)) {
			echo '<p class="first_article"></p>';
			echo '<div class="accroche">';
			echo $element->getAccroche();
			echo '</div>';
			echo '<hr />';
			echo '<div class="description">'.$element->getDescription().'</div>';
			if($type == 'article')
			  echo '<img class="element_logo" alt="'.$element->getTitle().'" src="/uploads/article/'.$element->getLogo().'" />';
		  }
		?>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
