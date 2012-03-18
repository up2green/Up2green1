<div id="main-menu">
	<ul>
  	<?php $first = true; ?>
    <?php	foreach($elements as $rank => $element) : ?>
    <li<?php echo ($first ? ' class="first" ' : '')?>>
      <?php if ($element instanceof lien) : ?>
        <?php echo '<a href="' . $element->getSrc() . '">' . $element->getTitle() . '</a>' ?>
      <?php elseif($element->getUniqueName() == 'programmes') : ?>
        <?php $items = $element->getActiveLinks(); ?>
        <?php echo '<a href="' . $items[0]->getSrc() . '">' . $items[0]->getTitle() . '</a>' ?>
        <div class="module">
          <div class="content">
                <ul>
                  <?php for($i=0; $i < sizeof($programmes); $i++) : ?>
                  <li<?php echo ($i == 0) ? ' class="first"' : ''; ?>>
                    <?php echo '<a href="/programme/' . $programmes[$i]->getSlug() . '">' . $programmes[$i]->getTitle() . '</a>' ?>
                  </li>
                  <?php endfor; ?>
                </ul>
          </div>
          <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php'); ?>
        </div>
      <?php else : ?>
        <?php include_partial('subMenu', array('category' => $element)); ?>
      <?php endif ?>
    </li>
    <?php $first = false ?>
    <?php endforeach; ?>
  </ul>
</div>
