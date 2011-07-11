<form action="" method="POST">
<table id="gmap-legend">
	<tr>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-plantation-vert.gif" alt="<?php echo __("Programmes actifs") ?>"/></td>
		<td class="label">
			<input type="checkbox" checked="checked"
			<?php echo __("Programmes actifs") ?>
		</td>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-organisme-violet.gif" alt="<?php echo __("Siège des organismes actifs") ?>"/></td>
		<td class="label"><?php echo __("Organismes actifs") ?></td>
	</tr>
	<tr>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-plantation-gris.gif" alt="<?php echo __("Programmes inactifs") ?>"/></td>
		<td class="label"><?php echo __("Programmes inactifs") ?></td>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-organisme-gris.gif" alt="<?php echo __("Siège des organismes inactifs") ?>"/></td>
		<td class="label"><?php echo __("Organismes inactifs") ?></td>
	</tr>
	<?php if(isset($partenaire)) : ?>
	<tr>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-plantation-violet.gif" alt="<?php echo __("Programmes soutenus par le partenaire {partner}", array(
				'{partner}' => $partenaire->getTitle()
		)) ?>"/></td>
		<td class="label"><?php echo __("Programmes soutenus par le partenaire {partner}", array(
				'{partner}' => $partenaire->getTitle()
		)) ?></td>
	</tr>
	<?php endif; ?>
</table>
</form>
