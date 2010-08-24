<?php
  // Affichage ou non du bloc conteneur (n'est pas affiché en AJAX)
  if (!isset($noBloc) || !$noBloc):
?>
<div class="module">
  <div class="cartouche">
    <div class="content"><p class="title_blog">Nos programmes</p></div>
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

  <div class="content blocContent">
    <div class="blocObjects">
      <?php
        endif;

        for($i = 0; $i < count($programmes); $i++) {
        	$p = $programmes[$i];
          echo ($i==0 ? '' : '<hr />') . '<div class="article' . ($i==0 ? ' first' : '') . '">' .
          	link_to($p->getTitle(), '@blog_programme?slug='.$p->getSlug(), array('class' => 'title')) .
          	'<p class="body">'.$p->getAccroche().'</p>' .
          	link_to(__('read_more'), '@blog_programme?slug='.$p->getSlug(), array('class' => 'read_more')) .
          	'</div>';
        }

        // Sauvegardes des URLs pour charger les articles suivants / précédents (utilisés pour modifier l'URL des boutons en AJAX)
        echo '<span class="invisible prevResultsUrl">'.url_for('@blog?programmesOffset='.$offsets['prev'].'&changement=programmes', true).'</span>';
        echo '<span class="invisible nextResultsUrl">'.url_for('@blog?programmesOffset='.$offsets['next'].'&changement=programmes', true).'</span>';

        // Affichage ou non du bloc conteneur (n'est pas affiché en AJAX)
        if (!isset($noBloc) || !$noBloc):
      ?>
    </div>
    <!--
    <p class="first_article">
      <p class="ctn_texte">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.</p>
      <a href="#" class="left">lire la suite</a>
    </p>
    <p class="article">
      <p class="ctn_texte">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.</p>
      <a href="#" class="left">lire la suite</a>
    </p>
    -->
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

  <!-- borders blog foret-->
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
