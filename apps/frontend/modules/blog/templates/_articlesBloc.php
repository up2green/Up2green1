<?php
  // Affichage ou non du bloc conteneur (n'est pas affiché en AJAX)
  if (!isset($noBloc) || !$noBloc):
?>
<div class="module">
  <div class="cartouche">
    <div class="content">
      <p class="title_blog">Blog Foret</p>
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
        for($i = 0; $i < count($articles); $i++) {
          $a = $articles[$i];
          echo ($i==0 ? '' : '<hr />') . '<div class="article' . ($i==0 ? ' first' : '') . '">' .
          	link_to($a->getTitle(), '@blog_article?slug='.$a->getSlug(), array('class' => 'title')) .
          	'<p class="body">'.html_entity_decode($a->getAccroche()).'</p>' .
          	link_to(__('read_more'), '@blog_article?slug='.$a->getSlug(), array('class' => 'read_more')) .
          	'</div>';
        }

        // Sauvegardes des URLs pour charger les articles suivants / précédents (utilisés pour modifier l'URL des boutons en AJAX)
        echo '<span class="invisible prevResultsUrl">'.url_for('@blog?articlesOffset='.$offsets['prev'].'&changement=articles', true).'</span>';
        echo '<span class="invisible nextResultsUrl">'.url_for('@blog?articlesOffset='.$offsets['next'].'&changement=articles', true).'</span>';

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
        <a href="<?php echo url_for('@blog?articlesOffset='.$offsets['prev'].'&changement=articles'); ?>" class="button white loadFromUri prevResults">
          <?php echo image_tag("icons/top.png"); ?>
        </a>
      </span>
      <span class="btn_down">
        <a href="<?php echo url_for('@blog?articlesOffset='.$offsets['next'].'&changement=articles'); ?>" class="button white loadFromUri nextResults">
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
