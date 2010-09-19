"Code coupon","Crédit","Date d'utilisation" 
<?php foreach ($coupons as $coupon): ?>
"<?php echo $coupon->getCode() ?>","<?php echo $coupon->getCouponGen()->getCredit() ?>","<?php echo $coupon->getUsedAt() ?>"
<?php endforeach; ?>