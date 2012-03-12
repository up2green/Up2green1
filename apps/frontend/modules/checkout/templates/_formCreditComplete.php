<p class="important"><?php
if (empty ($error)) {
	echo format_number_choice(
			"(-Inf,1]Félicitations ! Votre compte a bien été crédité de {number} credit.|(1,+Inf]Félicitations ! Votre compte a bien été crédité de {number} credits.",
			array('{number}' => $credit),
			$credit
		);
}
else if($error === 'expired'){
	echo __("La transaction a expiré, merci de recommencer.");
}
else {
	echo __("Une erreur est survenue lors du paiement, merci de recommencer.");
	if (sfConfig::get('sf_debug')) {
		echo '<p style="border:1px solid #000; padding: 3px;">'.$message.'</p>';
	}
}
?></p>
