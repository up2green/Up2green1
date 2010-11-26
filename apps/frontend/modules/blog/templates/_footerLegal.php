<div id="footer_page">
  <div id="legal">
    <span>Up2green® 2010 </span>
    <?php foreach($category->getActiveLinks() as $link) : ?>
	<?php
		$linkDisplay = $link->getSrc();

		if(!preg_match('/mailto/', $linkDisplay)) {

			$prefix = sfConfig::get('app_url_blog');

			if(substr($linkDisplay, 0, 1) === '/') {
				$prefix = substr($prefix, 0, sizeof($prefix)-1);
			}

			$linkDisplay = $prefix.$linkDisplay;
		}
	?>
  	<span>| <a href="<?php echo $linkDisplay; ?>"><?php echo $link->getTitle(); ?></a></span>
  	<?php endforeach; ?>
  </div>
  <div id="copyright">
    <p>
      Développé par : Clément Gautier <br/>
      Graphisme : Smart-ID
    </p>
  </div>
</div>
