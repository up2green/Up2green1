<?php 
header('Content-Type: application/csv;charset=utf-8;name=up2green-coupons-non-utilises-'.date('d-m-Y').'.csv');
header('Content-Disposition: attachment;filename=up2green-coupons-non-utilises-'.date('d-m-Y').'.csv');

$columns = array(
	__("Code coupon"),
	__("Crédit"),
	__("Date de création"),
);

echo '"'.implode('","', $columns).'"';
?>

<?php foreach ($coupons as $coupon): ?>
"<?php echo $coupon->getCode() ?>","<?php echo $coupon->getCouponGen()->getCredit() ?>","<?php echo $coupon->getCreatedAt() ?>"
<?php endforeach; ?>
