<div id="body">
    <div id="center">
        <?php include_component('gmap', 'index'); ?>
    </div>
    <!-- for SEO the sidebar after the content -->
    <div id="left">
        <?php
        if ($sf_user->isAuthenticated()) {
            if (! is_null($partenaire)) include_partial('formPartenaire', array('partenaire' => $partenaire));
        }
        else {
            include_partial('formInscription', array());
            if ($nbArbresToPlant > 0)
                include_partial('formPlant', array(
                        'nbArbresToPlant'=>$nbArbresToPlant,
                        'showProgrammeNavigation' => $showProgrammeNavigation,
                        'programmes' => $programmes,
                ));
        }
        if (!isset($coupon)) include_partial('formCoupon', array("phraseCoupon" => $phraseCoupon));
        if (isset($coupon)) include_partial('formPlant', array('coupon' => $coupon, 'nbArbresToPlant' => $nbArbresToPlant, 'programmes' => $programmes));
        ?>
    </div>
</div>
