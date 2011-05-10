<?php 
header('Content-Type: vnd.ms-excel;');
header('Content-Disposition: attachment;filename=up2green-coupons-'.date('d-m-Y').'.csv');

$columns = array(
	__("Code coupon"),
	__("Crédit"),
	__("Utilisé ?"),
	__("Date d'utilisation"),
	__("Programmes"),
);

$fieldComma = $format == "xls" ? ';' : ',';
$fieldBound = '"';
$comma = $fieldBound.$fieldComma.$fieldBound;

// header
echo utf8_decode($fieldBound.implode($comma, $columns).$fieldBound)."\n";

foreach ($coupons as $coupon) {
	$date = $coupon['is_active'] ? '-' : $coupon['used_at'];
	$used = $coupon['is_active'] ? __("Non") : __("Oui");
	
	// Build la liste des programmes
	
	if(isset($couponProgrammes[$coupon['id']])) {
		$strProgrammes = '';
		foreach ($couponProgrammes[$coupon['id']] as $idProgramme => $nbTree) {
				$strProgrammes .= $programmes[$idProgramme]['Translation'][$sf_user->getCulture()]['title'] . "(".$nbTree."), ";
		}
		$strProgrammes = substr($strProgrammes, 0, -2);
	}
	else {
		$strProgrammes = '-';
	}
	
	echo utf8_decode($fieldBound.$coupon['code'].$comma.$couponGens[$coupon['gen_id']]['credit'].$comma.$used.$comma.$date.$comma.$strProgrammes.$fieldBound)."\n";
}

?>