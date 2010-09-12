<div id="form_programme_plantation" class="module">
    <img class="title corner left" src="/images/module/green/icon/coupon.png" alt="" />
    <p class="title">Coupon</p>
    <div class="content">
        <p><?php echo $phraseCoupon ?></p><br /><br />
        <p>On vous a offert un coupon ou vous vous en êtes vous même offert un ? Entrez son code ici et planter vos arbres dès maintenant !</p>
        <form action="" method="post">
            <p class="center"><input type="text" name="code" value="Numéro de coupon" title="Numéro de coupon" /></p>
            <p class="center"><input type="submit" class="button white" name="numCouponToUse" value="Utiliser" /></p>
        </form>

    </div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>