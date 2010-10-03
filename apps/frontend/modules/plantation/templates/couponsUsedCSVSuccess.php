<?php 
header('Content-Type: application/csv;charset=utf-8;name=up2green-coupons-utilises-'.date('d-m-Y').'.csv');
header('Content-Disposition: attachment;filename=up2green-coupons-utilises-'.date('d-m-Y').'.csv');
?>

"Code coupon","Crédit","Date d'utilisation","Programmes"
<?php foreach ($coupons as $coupon): ?>
"<?php echo $coupon->getCode() ?>","<?php echo $coupon->getCouponGen()->getCredit() ?>","<?php echo $coupon->getUsedAt() ?>","<?php echo $coupon->getFormatedListProgrammes()?>"
<?php endforeach; ?>
