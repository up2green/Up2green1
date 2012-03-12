<p class="important"><?php
if (empty ($error)) {
	echo format_number_choice(
		"(-Inf,1]Félicitations ! Votre coupon d'un arbre à bien été envoyé à {mail}|(1,+Inf]Félicitations ! Votre coupon de {number} arbres à bien été envoyé à {mail}",
		array(
			'{number}' => $product->getCredit(),
			'{mail}' => $mail,
		),
		$product->getCredit()
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