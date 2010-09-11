<?php use_helper('Date'); ?> 
<?php if (sizeof($coupons) > 0) : ?>
<div id="form_programme_plantation" class="module">
    <img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
    <p class="title little indent">Coupons non utilisés (<?php echo sizeof($coupons) ?>)</p>
    <div class="content">
        <?php if(sizeof($coupons) > sfConfig::get('app_max_programme_plantation_list')) : ?>
        <center><span id="slideUp" class="button white">
            <img src="/images/icons/top.png" alt="Haut"/>
        </span></center>
        <?php endif; ?>

        <ul>
            <?php foreach($coupons as $coupon) : ?>
            <li>
                <span class="bigitem">
                    <?php echo $coupon->getCode(); ?> [<?php echo $coupon->getCouponGen()->getCredit() ?> arbre(s)]
                    Généré le <?php echo format_date($coupon->getCreatedAt(), 'p', $sf_user->getCulture());?>
                </span>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php if(sizeof($coupons) > sfConfig::get('app_max_programme_plantation_list')) : ?>
        <center><span id="slideDown" class="button white">
            <img src="/images/icons/bottom.png" alt="Bas"/>
        </span></center>
        <?php endif; ?>
    </div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
<?php endif; ?>

<?php if (sizeof($couponsUsed) > 0): ?>
<div id="form_programme_plantation" class="module">
    <img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
    <p class="title little indent">Coupons utilisés (<?php echo sizeof($couponsUsed) ?>)</p>
    <div class="content">
        <?php if($showCouponNavigationUsed) : ?>
        <span id="slideUp" class="button white">
            <img src="/images/icons/top.png" alt="Haut"/>
        </span>
        <?php endif; ?>

        <ul>
            <?php foreach($couponsUsed as $coupon) : ?>
            <li>
                <span class="bigitem"><?php echo $coupon->getCode(); ?> [<?php echo $coupon->getCouponGen()->getCredit() ?> arbre(s)]
                    Utilisé le <?php echo format_date($coupon->getUsedAt(), 'p', $sf_user->getCulture()) ?></span>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php if ($showCouponUsedNavigation) : ?>
        <span id="slideDown" class="button white">
            <img src="/images/icons/bottom.png" alt="Bas"/>
        </span>
        <?php endif; ?>
    </div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
<?php endif; ?>