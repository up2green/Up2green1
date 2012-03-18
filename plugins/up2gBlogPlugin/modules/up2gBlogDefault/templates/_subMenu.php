<?php $items = $category->getActiveLinks(); ?>
<?php for ($i=0; $i < sizeof($items); $i++) : ?>
<?php if ($i == 0) : ?>

<?php echo '<a href="' . $items[$i]->getSrc() . '">' . $items[$i]->getTitle() . '</a>' ?>
<div class="module">
  <div class="content">
        <ul>
          <?php else : ?>
          <li<?php echo ($i == 1) ? ' class="first"' : ''; ?>>
            <?php echo '<a href="' . $items[$i]->getSrc() . '">' . $items[$i]->getTitle() . '</a>' ?>
          </li>
          <?php endif; ?>
<?php endfor ?>
        </ul>
  </div>
  <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php'); ?>
</div>