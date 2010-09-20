"Code coupon";"Crédit";"Date d'utilisation";"Programmes"
<?php foreach ($coupons as $coupon): ?>
"<?php echo $coupon->getCode() ?>";"<?php echo $coupon->getCouponGen()->getCredit() ?>";"<?php echo $coupon->getUsedAt() ?>";"<?php echo $coupon->getFormatedListProgrammes()?>"
<?php endforeach; ?>