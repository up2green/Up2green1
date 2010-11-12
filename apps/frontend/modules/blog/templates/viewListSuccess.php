<div class="colRight">
  <?php
    if($type == 'article')
      include_component('blog', 'programmesBloc');
    else
      include_component('blog', 'articlesBloc');
    include_component('blog', 'partenairesBloc');
  ?>
</div>

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
			<div class="accroche"><?php echo $element->getAccroche() ?></div>
			<div class="description"><?php echo $element->getDescription(); ?></div>
			<?php if($type == 'article') : ?>
			<img class="element_logo" alt="<?php echo $element->getTitle(); ?>" src="/uploads/article/<?php echo $element->getLogo(); ?>" />
			<?php endif; ?>
		</p>
  </div>
  <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
<?php endforeach; ?>


