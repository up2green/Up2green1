<div id="main-menu">
	<ul>
  	<?php foreach($category->getActiveLinks() as $link) : ?>
  	<li>
  		<a href="<?php echo $link->getSrc(); ?>"><?php echo $link->getTitle(); ?></a>
  	
			<!-- bidouille temporaire pour les programmes -->
			<?php if($link->getSrc() == '/programme') : ?>
				<div class="module">
					<div class="content">
						<ul>
							<?php foreach($programms as $programm) : ?>
							<li><a href="/programme/<?php echo $programm->getSlug(); ?>"><?php echo $programm->getTitle(); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
				</div>
			<?php endif; ?>
  	
  	</li>
  	<?php endforeach; ?>
  	
  	<?php foreach($category->getActiveSubs() as $sub_categorie) : ?>
  	<li>
      Sub
      <div class="module">
        <div class="content">
          <ul>
						<?php foreach($category->getActiveLinks() as $link) : ?>
						<li><a href="<?php echo $link->getSrc(); ?>"><?php echo $link->getTitle(); ?></a></li>
						<?php endforeach; ?>
					</ul>
        </div>
        <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
      </div>
    </li>
  	<?php endforeach; ?>
  </ul>
</div>
