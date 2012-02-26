<div id="body">

	<?php include_partial('searchForm', array('form' => $form)); ?>
  
  <div id="searchResults">
  
    <?php if(!empty($singleShopResult)) : ?>
    <div class="shop-result">
      <?php include_partial('shop', array('result' => $singleShopResult)); ?>
    </div>
    <?php endif; ?>

    <?php if(!empty($pubResults)) : ?>
    <div class="pub-result">
      <?php foreach ($pubResults as $result) : ?>
      <?php include_partial('pub', array('result' => $result)); ?>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="<?php echo $typeSlug ?>-result">

      <?php if (empty ($results)) : ?>
      <p style="text-align: center; font-style: italic; font-weight: bold;">
        <?php echo __("Aucun résultat ne correspond à votre recherche.") ?>
      </p>
      <?php endif; ?>

      <?php foreach ($results as $result) : ?>
      <?php include_partial($typeSlug, array('result' => $result)); ?>
      <?php endforeach; ?>

    </div>

    <div class="clear"></div>

    <?php if(sizeof($results) >= sfConfig::get('app_base_search')) : ?>
    <div class="more-result">
      <span id="searchMore" class="button white big">
        <?php echo __("Plus de Résultats") ?>
      </span>
    </div>
    <?php endif; ?>

  </div>
</div>