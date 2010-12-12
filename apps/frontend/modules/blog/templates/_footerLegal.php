<div id="footer_page">
  <div id="legal">
    <span>Up2green® 2010 </span>
    <?php foreach($category->getActiveLinks() as $link) : ?>
	<?php
		$linkDisplay = $link->getSrc();
		$target = '_self';

		if(preg_match('/http/', $linkDisplay)) {
			$target = '_blank';
		}
	?>
  	<span>| <a target="<?php echo $target; ?>" href="<?php echo $linkDisplay; ?>"><?php echo $link->getTitle(); ?></a></span>
  	<?php endforeach; ?>
  </div>
  <div id="copyright">
    <p>
      Développé par : Clément Gautier <br/>
      Graphisme : Smart-ID
    </p>
  </div>
</div>
