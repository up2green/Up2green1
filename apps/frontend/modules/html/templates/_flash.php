<?php

function getFlashNotice($qName) {
	switch($qName) {
		case 'creation-compte': return __("Vous êtes maintenant inscrit et connecté à up2green.");
		case 'modif-ok': return __("Vos modifications ont bien été prises en compte.");
		case 'email-confirmation': return __("Vous aller recevoir un email attestant de votre plantation.");
		case 'plant-succes': return __("Vos arbres ont bien été plantés !");
		case 'invitation-success': return __("Vos invitations ont bien été envoyées.");
		case 'cadeau-arbre-new': return __("Vous avez gagné un arbre grâce à l'ouverture de votre compte !");
		default: return $qName;
	}
}

function getFlashError($qName) {
	switch($qName) {
		case 'coupon-already-user': return __("Ce coupon a déjà été utilisé");
		case 'error-plant-all': return __("Veuillez planter tous vos arbres avant de valider !");
		case 'error-deco': return __("Vous avez été déconnecté");
		case 'invalid-coupon': return __("Numéro de coupon invalide");
		case 'not-enough-credit': return __("Vous n'avez pas assez de crédits arbres.");
		case 'form-error': return __("Formulaire invalide.");
		case 'invitation-empty': return __("Veuillez remplir au moins une addresse mail.");
		default: return $qName;
	}
}

if ($sf_user->hasFlash('notice') || $sf_user->hasFlash('error')) {
	echo '<script type="text/javascript">';
	echo '$(document).ready(function(){';

	if ($sf_user->hasFlash('notice')) {
		foreach($sf_user->getFlashArray('notice') as $flash) {
			echo '
				$.gritter.add({
					title: "'.__("Notice").'",
					class_name: "flash_notice",
					image: "/images/icons/48x48/tick.png",
					text: "'.getFlashNotice($flash).'"
				});
			';
		}
	}

	if ($sf_user->hasFlash('error')) {
		foreach($sf_user->getFlashArray('error') as $flash) {
			echo '
				$.gritter.add({
					title: "'.__("Erreur").'",
					class_name: "flash_error",
					image: "/images/icons/48x48/error.png",
					text: "'.getFlashError($flash).'"
				});
			';
		}
	}

	echo '});';
	echo '</script>';

}
