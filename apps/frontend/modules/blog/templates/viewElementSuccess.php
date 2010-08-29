<div class="module module2col">
  <div class="content">
    <div class="cartouche">
      <div class="content">
        <p class="title_blog"><?php echo $element->getTitle(); ?></p>
      </div>
      <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
    </div>
    <?php
      if(isset($element)) {
        echo '<p class="first_article"></p>';
        echo '<div class="accroche">';
        echo html_entity_decode($element->getAccroche());
        echo '</div>';
        echo '<hr />';
        echo '<div class="description">'.html_entity_decode($element->getDescription()).'</div>';
        if($type == 'article')
          echo '<img class="element_logo" alt="'.$element->getTitle().'" src="/uploads/article/'.$element->getLogo().'" />';
      }
    ?>
  </div>
  <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

<div class="colRight">
  <?php
    if($type == 'article')
      include_component('blog', 'programmesBloc');
    elseif($type == 'programme')
      include_component('blog', 'articlesBloc');
    include_component('blog', 'partenairesBloc');
  ?>
</div>
