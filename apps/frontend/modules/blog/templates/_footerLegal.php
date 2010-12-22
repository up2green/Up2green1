<div id="footer_page">
  <div id="legal">

    <?php 
		$first = true;
		foreach($category->getActiveLinks() as $link) :

		$linkDisplay = $link->getSrc();
		$target = '_self';

		if(preg_match('/http/', $linkDisplay)) {
			$target = '_blank';
		}

		echo '<span>';

		if(!$first) {
			echo ' | ';
		}
	?>
  	<a target="<?php echo $target; ?>" href="<?php echo $linkDisplay; ?>"><?php echo $link->getTitle(); ?></a></span>
  	<?php 
		$first = false;
		endforeach;
	?>
	<br />
	<p>
		Association Up2green Reforestation<br />
		38 rue Desaix<br />
		75015 Paris - FRANCE<br />
		Contact : <a href="mailto:contact@up2green.com">contact@up2green.com</a>
	</p>
  </div>
  <div id="copyright">
    <p>
      Développé par : Clément Gautier <br/>
      Graphisme : Smart-ID
    </p>
  </div>
</div>
