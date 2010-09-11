<div class="module">
    <img class="title middle left" src="/images/module/purple/module_icon-partenaires_55x55.png" alt="" />
    <p class="title little indent"><?php echo $partenaire->getTitle() ?></p>
    <div class="content">
        <p><?php echo $partenaire->getAccroche() ?></p>
        <p class="center">
            <a href="plantation/listeCouponsPartenaires" class="button rosy">Voir mes coupons</a>
        </p>
    </div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>