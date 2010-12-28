<?php

echo '<form id="formLanguage" action="'.url_for('@change_language').'">';
echo $form->renderHiddenFields(false);
echo $form->renderGlobalErrors();

echo '
	<a class="flag tooltip" href="#">
		<img src="/images/icons/32x32/lang/'.$current.'.png" />
		<span class="tooltip-content classic">'.$languages[$current].'</span>
	</a>
	<div class="flags-hidden">
		<ul>
';

foreach($languages as $key => $value) {
	if($key != $current) {
		echo '
			<li >
				<a class="flag tooltip" href="#">
				<img lang="'.$key.'" src="/images/icons/32x32/lang/'.$key.'.png" alt="'.$value.'" />
				<span class="tooltip-content classic">'.$value.'</span>
				</a>
			</li>';
	}
}
echo '
		</ul>
	</div>
	<input type="hidden" name="language" value="'.$current.'" />
	</form>
';