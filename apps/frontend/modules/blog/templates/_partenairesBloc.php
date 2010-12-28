<?php
  // Affichage ou non du bloc conteneur (n'est pas affiché en AJAX)
  if (!isset($noBloc) || !$noBloc):
?>
<div class="module">
  <div class="cartouche">
    <div class="content">
      <p class="title_blog"><?php echo __("L'Actualité web") ?></p>
    </div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
  </div>
  <div class="content blocContent">
    <div class="blocObjects">
      <?php
        endif;
        // Affichage des articles
        for($i = 0; $i < count($partenaires); $i++) {
        	$p = $partenaires[$i];
        	$target = (sfConfig::get('app_blog_partenaires_open_in_new_window', false))? 'target="_blank "' : "";
        	
          echo ($i==0 ? '' : '<hr />') . '<div class="article' . ($i==0 ? ' first' : '') . '">' .
          	'<a class="title" '.$target.' href="'.$p->getElementsByTagName('link')->item(0)->nodeValue.'">'.$p->getElementsByTagName('title')->item(0)->nodeValue.'</a>' .
          	'<p class="body"></p>' .
          	'<a class="read_more" '.$target.' href="'.$p->getElementsByTagName('link')->item(0)->nodeValue.'">'.__("Lire la suite").'</a>' .
          	'</div>';
        }

        // Sauvegardes des URLs pour charger les articles suivants / précédents (utilisés pour modifier l'URL des boutons en AJAX)
        echo '<span class="invisible prevResultsUrl">'.url_for('@blog?partenairesOffset='.$offsets['prev'].'&changement=partenaires', true).'</span>';
        echo '<span class="invisible nextResultsUrl">'.url_for('@blog?partenairesOffset='.$offsets['next'].'&changement=partenaires', true).'</span>';


        // Affichage ou non du bloc conteneur (n'est pas affiché en AJAX)
        if (!isset($noBloc) || !$noBloc):
      ?>
    </div>
    <p class="up_n_down">
      <span class="btn_up">
        <a href="<?php echo url_for('@blog?partenairesOffset='.$offsets['prev'].'&changement=partenaires'); ?>" class="button white loadFromUri prevResults">
          <?php echo image_tag("icons/top.png"); ?>
        </a>
      </span>
      <span class="btn_down">
        <a href="<?php echo url_for('@blog?partenairesOffset='.$offsets['next'].'&changement=partenaires'); ?>" class="button white loadFromUri nextResults">
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
