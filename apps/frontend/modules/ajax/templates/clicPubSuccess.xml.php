<?php
$messages = array(
	'success' => __("Vous avez été crédité de {number} crédits arbres sur votre compte !", array(
		'{number}' => sfConfig::get('app_gain_cpc').' <img src="/images/icons/16x16/arbre.png" alt="Arbre(s)" />'
	)),
	'error-log' => __("Vous avez déjà cliquez sur ce lien récemment."),
	'not-connected' => __("Connectez-vous pour créditer votre compte en crédit arbres.")
);

$messagesTitle = array(
	'success' => __("Notice"),
	'error-log' => __("Erreur"),
	'not-connected' => __("Info")
);

$messageContent = '';
$messageTitre = '';

if(!empty($message)) {
	$messageContent = $messages[$message];
}

if(!empty($message)) {
	$messageTitre = $messagesTitle[$message];
}

?>

<result>
	<messageTitle><?php echo $messageTitre; ?></messageTitle>
	<message><?php echo $messageContent; ?></message>
	<messageType><?php echo $messageType; ?></messageType>
	<messageImage><?php echo $messageImage; ?></messageImage>
</result>
