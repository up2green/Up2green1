<div class="colRight">
  <?php
    if($type == 'article')
      include_component('up2gBlogDefault', 'programmesBloc');
    else
      include_component('up2gBlogDefault', 'articlesBloc');
    include_component('up2gBlogDefault', 'partenairesBloc');
  ?>
</div>

<?php if(!count($pager)) :?>
<p><?php echo __("Aucuns éléments a afficher.") ?></p>
<?php else :?>
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
<div class="clear" ></div>
<?php if ($pager->haveToPaginate()): ?>
<?php include_partial('html/pager_content', array(
    'pager' => $pager,
    'url_for' => $route,
)); ?>
<?php endif; ?>

<div class="pagination_desc">
  <strong><?php echo count($pager) ?></strong> <?php echo format_number_choice("(-Inf,1]programme|(1,+Inf]programmes", array(), count($pager)) ?>
  <?php if ($pager->haveToPaginate()): ?>
    - <?php echo __("page {current}/{total}", array(
        '{current}' => $pager->getPage(),
        '{total}' => $pager->getLastPage()
    )) ?>
  <?php endif; ?>
</div>

<?php endif; ?>

