<div id="footer_page">
  <div id="legal">
    <span>Up2green® 2010 </span>
    <?php foreach($category->getActiveLinks() as $link) : ?>
  	<span>| <a href="<?php echo sfConfig::get('app_url_blog').$link->getSrc(); ?>"><?php echo $link->getTitle(); ?></a></span>
  	<?php endforeach; ?>
  </div>
  <div id="copyright">
    <p>
      Développé par : Clément Gautier <br/>
      Graphisme : Smart-ID
    </p>
  </div>
</div>
