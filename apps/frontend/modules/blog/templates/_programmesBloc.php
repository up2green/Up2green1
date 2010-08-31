<?php
  // Affichage ou non du bloc conteneur (n'est pas affiché en AJAX)
  if (!isset($noBloc) || !$noBloc):
?>
<div class="module programme_bloc">
  <div class="cartouche">
    <div class="content"><p class="title_blog">Nos programmes</p></div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
  </div>

  <div class="content blocContent">
    <div class="blocObjects">
      <?php
        endif;
        for($i = 0; $i < count($programmes); $i++) :
        	$p = $programmes[$i];
        	if($i!=0) :
      ?>
        	<hr />
        	<?php endif; ?>
        	
          <div class="article<?php echo ($i==0 ? ' first' : ''); ?>">
          <?php if($p->getLogo() != '' && file_exists(sfConfig::get('sf_upload_dir').'/programme/'.$p->getLogo())) : ?> 
          <img src="/uploads/programme/<?php echo $p->getLogo(); ?>" alt="Diapo Image">
          <?php endif; ?>
          <?php	echo link_to($p->getTitle(), '@blog_programme?slug='.$p->getSlug(), array('class' => 'title')); ?>
          <div class="body"><?php echo html_entity_decode($p->getAccroche()); ?></div>
         	<?php echo link_to(__('read_more'), '@blog_programme?slug='.$p->getSlug(), array('class' => 'read_more')); ?>
          </div>
          
        <?php endfor; ?>

        <?php
        // Sauvegardes des URLs pour charger les articles suivants / précédents (utilisés pour modifier l'URL des boutons en AJAX)
        echo '<span class="invisible prevResultsUrl">'.url_for('@blog?programmesOffset='.$offsets['prev'].'&changement=programmes', true).'</span>';
        echo '<span class="invisible nextResultsUrl">'.url_for('@blog?programmesOffset='.$offsets['next'].'&changement=programmes', true).'</span>';

        // Affichage ou non du bloc conteneur (n'est pas affiché en AJAX)
        if (!isset($noBloc) || !$noBloc):
      ?>
    </div>
    <p class="up_n_down">
      <span class="btn_up">
        <a href="<?php echo url_for('@blog?programmesOffset='.$offsets['prev'].'&changement=programmes'); ?>" class="button white loadFromUri prevResults">
          <?php echo image_tag("icons/top.png"); ?>
        </a>
      </span>
      <span class="btn_down">
        <a href="<?php echo url_for('@blog?programmesOffset='.$offsets['next'].'&changement=programmes'); ?>" class="button white loadFromUri nextResults">
          <?php echo image_tag("icons/bottom.png"); ?>
        </a>
      </span>
    </p>
  </div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
<?php
  endif;
?>
