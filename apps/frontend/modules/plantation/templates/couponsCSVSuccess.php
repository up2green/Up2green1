"Code coupon";"Crédit";"Date de création" 
<?php foreach ($coupons as $coupon): ?>
"<?php echo $coupon->getCode() ?>";"<?php echo $coupon->getCouponGen()->getCredit() ?>";"<?php echo $coupon->getCreatedAt() ?>"
<?php endforeach; ?>