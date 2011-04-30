<?php 
header('Content-Type: application/csv;charset=utf-8;name=up2green-coupons-'.date('d-m-Y').'.csv');
header('Content-Disposition: attachment;filename=up2green-coupons-'.date('d-m-Y').'.csv');

$columns = array(
	__("Code coupon"),
	__("Crédit"),
	__("Date d'utilisation"),
);

echo '"'.implode('","', $columns).'"';
?>

<?php foreach ($coupons as $coupon): ?>
"<?php echo $coupons['code'] ?>","<?php echo $couponGens[$coupons['gen_id']] ?>","<?php echo $coupons['is_active'] ? '-' : $coupons['used_at'] ?>"
<?php endforeach; ?>
