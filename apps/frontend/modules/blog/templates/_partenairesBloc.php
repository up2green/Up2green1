<?php
  // Affichage ou non du bloc conteneur (n'est pas affiché en AJAX)
  if (!isset($noBloc) || !$noBloc):
?>
<div class="module">
  <div class="cartouche">
    <div class="content">
      <p class="title_blog">Nos partenaires entreprises</p>
    </div>
    <span class="border bt"></span>
    <span class="border bb"></span>
    <span class="border bl"></span>
    <span class="border br"></span>
    <!-- corners -->
    <span class="corner ctl"></span>
    <span class="corner ctr"></span>
    <span class="corner cbl"></span>
    <span class="corner cbr"></span>
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
          echo '<p class="ctn_texte">'.$p->title.'</p>';
          $target = (sfConfig::get('app_blog_partenaires_open_in_new_window', false))? 'target="_blank "' : "";
          echo '<a class="left" '.$target.' href="'.$p->link.'">'.__('read_more').'</a>';
//          echo link_to(__('read_more'), $p->link, array('class' => 'left'));
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

  <!-- borders -->
  <span class="border bt"></span>
  <span class="border bb"></span>
  <span class="border bl"></span>
  <span class="border br"></span>
  <!-- corners -->
  <span class="corner ctl"></span>
  <span class="corner ctr"></span>
  <span class="corner cbl"></span>
  <span class="corner cbr"></span>
</div>
<?php
  endif;
?>