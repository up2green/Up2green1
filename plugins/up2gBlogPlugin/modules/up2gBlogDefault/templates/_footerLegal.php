<?php

echo '
	<div id="footer_page">
	  <div id="legal">
		<p>
';

$first = true;
foreach($category->getActiveLinks() as $link) {

	$target = (preg_match('/http/', $link->getSrc())) ? '_blank' : '_self';
	$comma = $first ? '' : ' | ';
	echo '
		<span>
			'.$comma.'
			<a target="'.$target.'" href="'.$link->getSrc().'">
				'.$link->getTitle().'
			</a>
		</span>
	';

	$first = false;
}

echo '
		</p>
		<p class="adress">Association Up2green Reforestation - 38 rue Desaix 75015 Paris - FRANCE</p>
		<p class="copyright">
			'.__("Développement : {society}", array('{society}' => '<a target="_blank" href="http://www.smartit.fr/">SmartIT</a>')).'
			| '.__("Graphisme : {society}", array('{society}' => '<a target="_blank" href="http://www.smart-id.fr/">Smart-ID</a>')).'
			| '.__("Intégration : {society}", array('{society}' => '<a target="_blank" href="http://mycoinfographie.artblog.fr/">mY.co Infographie</a>')).'
		</p>
	</div>
</div>
';
