<text><![CDATA[
<div class="gmap-info programme gmap-tabs-wrapper">
	<ul>
		<li><a href="#gmap-tabs-1-programme-<?php echo $programme->getId() ?>"><?php echo __("Info") ?></a></li>
		<?php if($programme->getOrganisme()) : ?>
		<li><a href="#gmap-tabs-2-programme-<?php echo $programme->getId() ?>"><?php echo __("Organisme") ?></a></li>
		<?php endif; ?>
	</ul>
	<div id="gmap-tabs-1-programme-<?php echo $programme->getId() ?>">
		<table>
			<tr>
				<?php if($programme->getLogo()) : ?>
				<td><img class="gmap-programme" src="/uploads/programme/<?php echo $programme->getLogo() ?>" alt="Diapo Image" /></td>
				<?php endif; ?>
				<td style="vertical-align: middle;font-size:13px;">
					<p><?php echo __("Capacité de plantation : {number}/{max} arbres plantés", array(
						'{number}' => number_format($programmeTrees, 0, ',', ' '),
						'{max}' => number_format($max, 0, ',', ' ')
					)) ?></p>
					<div class="programme-graph-wrapper">
						<div style="width: <?php echo $displayPourcent ?>%;" class="green" href="#"></div>
					</div>
					<?php if($sf_user->isAuthenticated()) : ?>
					<p style="color:#7AA520"><?php echo format_number_choice(
						"(-Inf,0]Vous n'avez pas encore planté d'arbre dans ce programme|(1)Vous avez planté un arbre dans ce programme|[1,+Inf]Vous avez planté {number} arbres dans ce programme",
						array('{number}' => $userProgrammeTrees),
						$userProgrammeTrees
					); ?></p>
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<div style="font-size:12px;" class="accroche-programme"><?php echo $programme->getAccroche(); ?></div>
		<a href="<?php echo sfConfig::get('app_url_blog') ?>/programme/<?php echo $programme->getSlug() ?>" class="read_more" target="_blank">Lire la suite</a>
	</div>
	<?php if($programme->getOrganisme()) : ?>
	<div id="gmap-tabs-2-programme-<?php echo $programme->getId() ?>" class="gmap-tab-programme-organisme">
		<h3><?php echo $programme->getOrganisme()->getTitle(); ?></h3>
		<?php echo $programme->getOrganisme()->getAccroche(); ?>
	</div>
	<?php endif; ?>
</div>
]]></text>
