<?php 
class libCoupon {

	public static $length = 9;
	public static $acceptedChars = 'ABCDEFGHKLMNOPQRSTWXYZ123456789';

	/**
	 * @param: String $prefix 
	 * @param: Array $exclude liste de code a exclure lors de l'exécution récursive
	 * @return: String numéro de coupon libre
	 * @descrpition: Retourne un code coupon non utilisé
	*/
	public static function getCodeUnused($prefix = '', $exclude = array()) {

		if(strlen($prefix) > self::$length) {
			throw new Exception(sprintf("Prefix size is > to the max (%s)", self::$length));
		}

		$prefix = self::cleanCode($prefix);

		do {
			$code = $prefix . self::cleanCode(self::getRandCode(self::$length - strlen($prefix)));
		} while (in_array($code, $exclude));

		$test = Doctrine_Core::getTable('coupon')
			->createQuery('c')
			->where('c.code = ?', $code)
			->fetchOne();
		
		if (!$test) {
			// code ok, not found in database
			return $code;
		}
		else if(strlen($prefix) >= self::$length) {
			// cant generate a valide code
			throw new Exception(sprintf("Coupon already exist with code %s", $code));
		}
		else {
			$q = Doctrine_Core::getTable('coupon')
				->createQuery('c')
				->select('c.code')
				->where('c.code LIKE ?', $prefix.'%');

			$results = $q->fetchArray();
			$possibilities = pow(strlen(self::$acceptedChars), self::$length - strlen($prefix));
			
			if($possibilities === sizeof($results) ) {
				// cant generate a valide code
				throw new Exception(sprintf("All possibilities with prefix %s are already used", $prefix));
			}
			else {
				$excluded = array();
				foreach($results as $result) {
					$excluded[] = $result['code'];
				}
				return self::getCodeUnused($prefix, $excluded);
			}
			
		}
	}

	/**
	 * @param: Integer $length Taille du code aléatoire
	 * @return: String code
	 * @description: génere un code aléatoire
	*/
	public static function getRandCode($length) {
		$max = strlen(self::$acceptedChars) - 1;
		$code = '';
		mt_srand((double)microtime()*1000000);
		while (strlen($code) < $length)
			$code .= self::$acceptedChars{mt_rand(0, $max)};

		return $code;
	}

	/**
	 * @param: String $code la chaine à épurer
	 * @return: String le code épuré 
	 * @description: prépare une chaine pour une utilisation comme code coupon
	*/ 
	public static function cleanCode($code) {
		// replace non letter or digits
		$code = preg_replace('#[^\\pL\d]+#u', '', $code);
		return strtoupper(trim($code));
	}

}
