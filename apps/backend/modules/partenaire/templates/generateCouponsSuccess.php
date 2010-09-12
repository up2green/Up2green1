<h1>Génération de coupons pour le partenaire "<?php echo $partenaire ?>"</h1>
<?php if (isset($tabCoupons)): ?>
<table>
    <?php foreach($tabCoupons as $coupon): ?>
    <tr><td><?php echo $coupon ?></td></tr>
    <?php endforeach ; ?>
</table>
<a href="<?php echo url_for('@partenaire') ?>">Retour</a>
<?php else: ?>
<form action="<?php echo url_for('@generate_coupons?id='. $partenaire->getId()); ?>" method="POST">
    <table>
        <?php echo $form ?>
        <tr>
            <td colspan="2">
                <a href="<?php echo url_for('@partenaire') ?>">Retour</a> <input type="submit" />
            </td>
        </tr>
    </table>
</form>
<?php endif; ?>
