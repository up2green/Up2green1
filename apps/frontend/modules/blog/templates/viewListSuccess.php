<?php foreach($elements as $element) : ?>
<div class="module module2col">
  <div class="content">
    <div class="cartouche">
      <div class="content">
        <p class="title_blog">
        	<?php echo $element->getTitle(); ?>
        </p>
      </div>
      <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
    </div>
    <p class="first_article">
			<h3><?php echo html_entity_decode($element->getAccroche()) ?></h3>';
			<p class="ctn_texte"><?php echo html_entity_decode($element->getDescription()); ?></p>';
			<?php if($type == 'article') : ?>
			<img class="element_logo" alt="<?php echo $element->getTitle(); ?>" src="/uploads/article/<?php echo $element->getLogo(); ?>" />
			<?php endif; ?>
		</p>
  </div>
  <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
<?php endforeach; ?>

<div class="colRight">
  <?php
    if($type == 'article')
      include_component('blog', 'programmesBloc');
    elseif($type == 'programme')
      include_component('blog', 'articlesBloc');
    include_component('blog', 'partenairesBloc');
  ?>
</div>
