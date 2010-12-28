<div class="module">
    <img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
    <p class="title little indent"><?php echo __("Devenez acteur de la reforestation") ?></p>
    <div class="content">
        <p><?php echo __("Créez votre compte et collectez GRATUITEMENT des arbres au fur et à mesure de vos recherches") ?></p>
        <p><?php echo __("Vous choisissez ensuite vous même où les planter sur la Planète parmi les programmes de reforestation que nous soutenons") ?></p>
        <p class="center">
            <a href="<?php echo url_for("@sf_guard_register") ?>" class="button gray disabled"><?php echo __("Bientot disponible") ?></a>
        </p>
    </div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
