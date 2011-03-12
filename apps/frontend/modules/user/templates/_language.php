<?php

function curPageURL() {
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

echo '<form method="post" id="formLanguage" action="'.url_for('/change_language').'">';

echo '
	<a title="'.$languages[$current].'" class="flag" href="#">
		<img src="/images/icons/32x32/lang/'.$current.'.png" />
	</a>
	<div class="flags-hidden">
		<ul>
';

foreach($languages as $key => $value) {
	if($key != $current) {
		echo '
			<li >
				<a title="'.$value.'" class="flag" href="#">
					<img lang="'.$key.'" src="/images/icons/32x32/lang/'.$key.'.png" alt="'.$value.'" />
				</a>
			</li>
		';
	}
}

echo '
		</ul>
	</div>
	<input type="hidden" name="language" value="'.$current.'" />
	<input type="hidden" name="fromUrl" value="'.curPageURL().'" />
';

echo '</form>';