<?php

function getFlashNotice($qName) {
	switch($qName) {
		case 'creation-compte':
			return __("Vous êtes maintenant inscrit et connecté à up2green.");
		case 'modif-ok':
			return __("Vos modifications ont bien été prises en compte.");
		default:
			return '';
	}
}

function getFlashError($qName) {
	switch($qName) {
		default:
			return '';
	}
}

if ($sf_user->hasFlash('notice') || $sf_user->hasFlash('error')) {
	echo '<script type="text/javascript">';
	echo '$(document).ready(function(){';

	if ($sf_user->hasFlash('notice')) {
		echo '
			$.gritter.add({
				title: "'.__("Notice").'",
				class_name: "flash_notice",
				image: "/images/icons/48x48/tick.png",
				text: "'.getFlashNotice($sf_user->getFlash('notice')).'"
			});
		';
	}

	if ($sf_user->hasFlash('error')) {
		echo '
			$.gritter.add({
				title: "'.__("Erreur").'",
				class_name: "flash_error",
				image: "/images/icons/48x48/error.png",
				text: "'.getFlashError($sf_user->getFlash('error')).'"
			});
		';
	}

	echo '});';
	echo '</script>';

}
