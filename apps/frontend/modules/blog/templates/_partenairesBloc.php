<?php
  // Affichage ou non du bloc conteneur (n'est pas affiché en AJAX)
  if (!isset($noBloc) || !$noBloc):
?>
<div class="module">
  <div class="cartouche">
    <div class="content">
      <p class="title_blog">Nos partenaires entreprises</p>
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
          if($i==0)
            echo '<p class="first_article">';
          else
            echo '<p class="article">';
          echo '<p class="ctn_texte">'.$p->getElementsByTagName('title')->item(0)->nodeValue.'</p>';
          $target = (sfConfig::get('app_blog_partenaires_open_in_new_window', false))? 'target="_blank "' : "";
          echo '<a class="left" '.$target.' href="'.$p->getElementsByTagName('link')->item(0)->nodeValue.'">'.__('read_more').'</a>';
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
