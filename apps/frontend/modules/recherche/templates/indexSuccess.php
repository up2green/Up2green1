<div id="body">

	<?php include_partial('searchForm', array('form' => $form)); ?>

	<?php
    $tooltip = __("Le financement des arbres provient des revenus publicitaires reversés à l’association Up2green Reforestation par Yahoo (ou par les sites marchands affiliés pour le moteur Achats) :").
      '<ol style=\'margin: 5px 25px;text-align:left;list-style-type:decimal;\'>
        <li>'.__("Vous effectuez une recherche avec le moteur Up2green.").'</li>
        <li>'.__("Peut-être allez-vous cliquer sur un lien sponsorisé intéressant ?").'</li>
        <li>'.__("Le sponsor rémunère Yahoo pour chaque clic.").'</li>
        <li>'.__("Yahoo reversent une grande partie de cette somme à l'association Up2green.").'</li>
        <li>'.__("Up2green reverse sur votre compte la moitié de cette somme sous forme de crédits arbres (l'autre moitié sert à assurer les frais de structure et de développement de l'association ainsi que de nos propres projets d'agroforesterie).").'</li>
      </ol>';
  ?>

  <div id="home" class="hide-onload" style="opacity: 0;">

    <div class="module acteur">
      <img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />

      <p class="title">
        <?php if (!$sf_user->isAuthenticated()): ?>
          <?php echo __("Devenez acteur de la reforestation") ?>
        <?php else: ?>
          <?php echo __("Plantez vos arbres") ?>
        <?php endif; ?>
      </p>

      <div class="content">

        <!-- AddThis Follow BEGIN -->
        <div class="addthis_toolbox addthis_32x32_style addthis_default_style" style="line-height:32px">
          <strong><?php echo __("Suivez nous sur les réseaux sociaux !") ?></strong>
          <a class="addthis_button_facebook_follow" addthis:userid="Up2green"></a>
          <a class="addthis_button_twitter_follow" addthis:userid="up2green"></a>
        </div>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f5d372f3fb98941"></script>
        <!-- AddThis Follow END -->
        <hr />

        <?php if (!$sf_user->isAuthenticated()): ?>
          <p style="padding:5px;">
            <?php echo __("Créez votre compte et collectez GRATUITEMENT des arbres au fur et à mesure de vos recherches") ?>
            <img tooltiped="true" title="<?php echo $tooltip ?>" src="/images/icons/16x16/consulting.png" />
          </p>
          <p style="padding:5px;"><?php echo __("Vous choisissez ensuite vous même où les planter sur la Planète parmi les programmes de reforestation que nous soutenons") ?></p>
          <p class="important"><?php echo __("Gagnez un arbre à l’ouverture de votre compte Up2green et plantez le dès à présent sur la Planète !") ?></p>
          <p class="center">
            <a href="<?php echo url_for("user/inscription"); ?>" class="button green">
              <strong><?php echo __("Créer un compte") ?></strong>
            </a>
          </p>
        <?php else: ?>
          <p><?php echo __("Vous pouvez dès à présent accéder à la plateforme de reforestation et planter vos arbres si vous en avez collectés suffisement") ?></p>
          <p class="center">
            <a target="_blank" href="<?php echo url_for("plantation/index"); ?>" class="button green">
              <?php echo __("Accéder à la plateforme de reforestation") ?>
            </a>
          </p>
        <?php endif; ?>
      </div>

      <?php include_partial('global/border_and_corner') ?>
    </div>

    <div class="module statistiques">
      <img class="title middle right" src="/images/module/green/icon/stats.png" alt="" />
      <p class="title"><?php echo __("Statistiques") ?></p>
      <div class="content">
        <p><img class="img_map" src="/images/moteur/stats_maps_200x70.png" /></p>
        <p tooltiped="true" title="<?php echo __("Les forêts sont reconnues pour être de véritables puits de carbone.<br /> A titre indicatif, d’après l’ONU, pendant sa croissance un arbre capte en moyenne 12 kgs de CO2 par an et rejette l’oxygène nécessaire à la respiration dune famille de 4 personnes") ?>" class="center" style="padding:10px 0;">
          <?php echo __("Arbres plantés : {number}", array('{number}' => '<strong style="color:#015F00;">'.$totalTrees.'</strong>')) ?> <br/>
          <?php echo __("soit plus de {number} tonnes de CO<sub>2</sub> qui seront stockées pendant leur croissance", array('{number}' => '<strong style="color:#015F00;">'.number_format($totalTrees*sfConfig::get('app_conversion_tree_co2'), 2, ',', ' ').'</strong>')) ?>
          <img src="/images/icons/16x16/consulting.png" />
        </p>
      </div>
      <?php include_partial('global/border_and_corner') ?>
    </div>

    <?php if (!$sf_user->isAuthenticated()): ?>
    <div class="module purple partenaires">
      <img class="title middle right" src="/images/module/purple/icon/icon-partenaires.png" alt="" />
      <p class="title"><?php echo __("Partenaires") ?></p>
      <div class="content">
        <p><?php echo __("Entreprises et collectivités, devenez acteur de la reforestation en impliquant vos administrés, client et colaborateur...") ?></p>
        <div class="lien_partenaires righter">
          <a target="_blank" href="<?php echo sfConfig::get('app_url_blog'); ?>"><?php echo __("plus d'informations ici") ?></a>
        </div>
      </div>
      <?php include_partial('global/border_and_corner') ?>
    </div>
    <?php endif; ?>

  </div>

</div>
