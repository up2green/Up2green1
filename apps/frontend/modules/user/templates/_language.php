<?php

echo '<form method="post" id="formLanguage" action="'.url_for('/change_language').'">';

echo '
	<a class="flag" href="#">
		<img src="/images/icons/32x32/lang/'.$current.'.png" />
	</a>
	<div class="flags-hidden">
		<ul>
';

foreach($languages as $key => $value) {
	if($key != $current) {
		echo '
			<li >
				<a class="flag" href="#">
					<img lang="'.$key.'" src="/images/icons/32x32/lang/'.$key.'.png" alt="'.$value.'" />
				</a>
			</li>
		';
	}
}

echo '
		</ul>
	</div>
	'.$form->renderHiddenFields(false).'
	<input type="hidden" name="language" value="'.$current.'" />
	<input type="hidden" name="fromUrl" value="'.libUrl::getCurentUrl().'" />
';

echo '</form>';
