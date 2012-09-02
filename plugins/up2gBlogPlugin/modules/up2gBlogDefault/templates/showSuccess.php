<div class="module module2col">
  <div class="content">
    <div class="cartouche">
      <div class="content">
        <p class="title_blog"><?php echo $element->getTitle(); ?></p>
      </div>
      <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
    </div>
    <p class="first_article"></p>
    <div class="accroche" style="min-height: 70px;">
      <?php if(in_array($type, array('programme', 'organisme', 'article')) && $element->getLogo() != '') : ?>
          <img class="article-miniature" src="/uploads/<?php echo $type ?>/<?php echo $element->getLogo(); ?>" />
      <?php elseif ($type === 'partenaire') : ?>
        <?php foreach ($element->getLogos() as $logo) : ?>
          <img class="article-miniature" src="/uploads/<?php echo $type ?>/<?php echo $element->getId(); ?>/<?php echo $logo->getSrc(); ?>" alt="Image">
        <?php endforeach; ?>
      <?php endif ?>
      <?php echo $element->getAccroche(); ?>
    </div>
    <hr />
    <div class="description">
      <?php echo $element->getDescription() ?>
    </div>
  </div>
  <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

<div class="colRight">
  <?php
    if($type == 'article')
      include_component('up2gBlogDefault', 'programmesBloc');
    elseif($type == 'programme')
      include_component('up2gBlogDefault', 'articlesBloc');
    include_component('up2gBlogDefault', 'partenairesBloc');
  ?>
</div>
