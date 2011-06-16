<?php

require_once dirname(__FILE__).'/../bootstrap/Doctrine.php';
 
$t = new lime_test(8);
 
$t->comment('libCoupon');

$code = libCoupon::getCodeUnused();
$result = Doctrine_Core::getTable("coupon")
	->createQuery('c')
	->where('c.code = ?', $code)
	->fetchOne();

$t->is($result, false, '::getCodeUnused() get a random unused code without prefix');
$t->is(libCoupon::cleanCode("   TEST "), "TEST", '::cleanCode() trim all white-spaces');
$t->is(libCoupon::cleanCode("TEST    TEST"), "TESTTEST", '::cleanCode() clean spaces between two words');
$t->is(libCoupon::cleanCode("test"), "TEST", '::cleanCode() uppercase');
$t->is(strlen(libCoupon::getRandCode(16)), 16, '::getRandCode() returning the correct code size');

saveCode($code);

try {
	libCoupon::getCodeUnused($code);
	$t->fail('::getCodeUnused() Trying to get a random code with a full prefix that exist and dont get an exception');
}
catch (Exception $e) {
	$t->pass('::getCodeUnused() Exception caught successfully when trying to get a code that already exist');
}

try {
	$supMaxPrefix = libCoupon::getRandCode(libCoupon::$length + 1);
	libCoupon::getCodeUnused($supMaxPrefix);
	$t->fail(sprintf("::getCodeUnused() Trying to get a code with a suffix length > %s", libCoupon::$length));
}
catch (Exception $e) {
	$t->pass('::getCodeUnused() Exception caught successfully when trying to get a code with a prefix length sup to max');
}

$randPrefix = libCoupon::getRandCode(libCoupon::$length - 1);
$possibilities = strlen(libCoupon::$acceptedChars);
for ($i=0; $i <= $possibilities; $i++) {
	if($i == $possibilities) {
		try {
			libCoupon::getCodeUnused($randPrefix);
			$t->fail('::getCodeUnused() No more possibilities to get an unused code and no Exception caught');
		}
		catch (Exception $e) {
			$t->pass('::getCodeUnused() Exception caught successfully when no more possibilities');
		}
	}
	else {
		saveCode(libCoupon::getCodeUnused($randPrefix));
	}
}

function saveCode($code) {
	$couponGen = Doctrine_Core::getTable('couponGen')
		->createQuery('cg')
		->fetchOne();

	$coupon = new coupon();
	$coupon->setCode($code);
	$coupon->setCouponGen($couponGen);
	$coupon->save();
}
