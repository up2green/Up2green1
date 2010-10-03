<?php 
header('Content-Type: application/csv;charset=utf-8;name=up2green-coupons-non-utilises-'.date('d-m-Y').'.csv');
header('Content-Disposition: attachment;filename=up2green-coupons-non-utilises-'.date('d-m-Y').'.csv');
?>

"Code coupon","Crédit","Date de création"
<?php foreach ($coupons as $coupon): ?>
"<?php echo $coupon->getCode() ?>","<?php echo $coupon->getCouponGen()->getCredit() ?>","<?php echo $coupon->getCreatedAt() ?>"
<?php endforeach; ?>
