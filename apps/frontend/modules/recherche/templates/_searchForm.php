<?php echo form_tag('/search', array('id' => 'searchForm', 'method' => 'get')) ?>
  <div class="search">
    <?php $form['q']->getWidget()->setAttribute('data-previous-value', $form['q']->getValue()); ?>
    <?php echo $form['q'] ?>
    <input type="submit" value="<?php echo __("Rechercher") ?>" class="button white small" />
  </div>

  <div class="filtres">
    <span searchMode="<?php echo SearchEngine::WEB ?>" class="button top-not-rounded <?php echo ($form['type']->getValue() == SearchEngine::WEB ? 'green active' : 'gray'); ?> medium first"><?php echo __("Web") ?></span>
    <span searchMode="<?php echo SearchEngine::IMG ?>" class="button top-not-rounded <?php echo ($form['type']->getValue() == SearchEngine::IMG ? 'green active' : 'gray'); ?> medium"><?php echo __("Images") ?></span>
    <span searchMode="<?php echo SearchEngine::NEWS ?>" class="button top-not-rounded <?php echo ($form['type']->getValue() == SearchEngine::NEWS ? 'green active' : 'gray'); ?> medium"><?php echo __("News") ?></span>
    <?php if (sfConfig::get('app_show_shop_results', true)) :?>
    <span searchMode="<?php echo SearchEngine::SHOP ?>" class="button top-not-rounded <?php echo ($form['type']->getValue() == SearchEngine::SHOP ? 'orange active' : 'orange-gray hover'); ?> medium">
      <?php echo __("Achats") ?>
    </span>
    <?php endif; ?>
  </div>

  <?php echo $form->renderHiddenFields() ?>
</form>