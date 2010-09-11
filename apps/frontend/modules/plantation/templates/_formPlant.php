<!-- module -->
<form action="" method="post">
<div id="form_programme_plantation" class="module">
    <img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
    <p class="title little indent">Devenez acteur de la reforestation</p>
    <div class="content">
        <p><?php if (isset($coupon)) : ?>Coupon n° <?php echo $coupon->getCode() ?><?php endif; ?></p>
        <p>Vous avez <span id="nbArbresToPlantLeft"><?php echo $nbArbresToPlant ?></span> arbre(s) à planter.<br /><br /></p>
        <?php if(sizeof($programmes) > sfConfig::get('app_max_programme_plantation_list')) : ?>
        <span id="slideUp" class="button white">
            <img src="/images/icons/top.png" alt="Haut"/>
        </span>
        <?php endif; ?>

        <ul>
            <?php foreach($programmes as $programme) : ?>
            <li>
                <span class="item"><?php echo $programme->getTitle(); ?></span>
                <span class="action">
                    <input type="hidden" name="nbArbresProgrammeHidden_<?php echo $programme->getId() ?>" id="nbArbresProgrammeHidden_<?php echo $programme->getId() ?>" value="0" />
                    <span id="nbArbresProgramme_<?php echo $programme->getId() ?>"></span>
                    <button id="addArbreProgramme_<?php echo $programme->getId() ?>" class="button really-small green">+</button>
                    <button id="removeArbreProgramme_<?php echo $programme->getId() ?>" class="button really-small gray">-</button>
                </span>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php if(sizeof($programmes) > sfConfig::get('app_max_programme_plantation_list')) : ?>
        <span id="slideDown" class="button white">
            <img src="/images/icons/bottom.png" alt="Bas"/>
        </span>
        <?php endif; ?>
        <p class="center">
            <span id="buttonArbresProgramme" class="button gray">Planter mes arbres !</span>
            <a href="@plantation" class="button white">Annuler</a>
        </p>

    </div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
    <input type="submit" name="submitArbresProgramme" id="submitArbresProgramme" style="display: none;" />
</form>