<?php 
header('Content-Type: application/csv;charset=UTF-8;name=up2green-coupons-'.date('d-m-Y').'.csv');
header('Content-Disposition: attachment;filename=up2green-coupons-'.date('d-m-Y').'.csv');

$columns = array(
	__("Code coupon"),
	__("Crédit"),
	__("Utilisé ?"),
	__("Date d'utilisation"),
);

echo '"'.implode('","', $columns).'"';
?>

<?php foreach ($coupons as $coupon): ?>
"<?php echo $coupon['code'] ?>","<?php echo $couponGens[$coupon['gen_id']]['credit'] ?>","<?php echo $coupon['is_active'] ? __("Non") : __("Oui") ?>","<?php echo $coupon['is_active'] ? '-' : $coupon['used_at'] ?>"
<?php endforeach; ?>
