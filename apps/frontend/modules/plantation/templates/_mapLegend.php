<form name="mapMode" action="" method="POST">
<table id="gmap-legend">
	<tr>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-plantation-vert.gif" alt="<?php echo __("Programmes actifs") ?>"/></td>
		<td class="label">
			<?php echo $mapModeForm['displayProgrammeActif']; ?>
			<?php echo __("Programmes actifs") ?>
		</td>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-organisme-violet.gif" alt="<?php echo __("Siège des organismes actifs") ?>"/></td>
		<td class="label">
			<?php echo $mapModeForm['displayOrganismeActif']; ?>
			<?php echo __("Organismes actifs") ?>
		</td>
	</tr>
	<tr>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-plantation-gris.gif" alt="<?php echo __("Programmes inactifs") ?>"/></td>
		<td class="label">
			<?php echo $mapModeForm['displayProgrammeInactif']; ?>
			<?php echo __("Programmes inactifs") ?>
		</td>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-organisme-gris.gif" alt="<?php echo __("Siège des organismes inactifs") ?>"/></td>
		<td class="label">
			<?php echo $mapModeForm['displayOrganismeInactif']; ?>
			<?php echo __("Organismes inactifs") ?>
		</td>
	</tr>
	<tr>
    <?php if(isset($partenaire)) : ?>
		<td class="icon"><img src="/images/gmap/pointeur/icon-64x64-plantation-violet.gif" alt="<?php echo __("Programmes soutenus par le partenaire {partner}", array(
      '{partner}' => $partenaire->getTitle()
		)) ?>"/></td>
		<td class="label">
			<?php echo $mapModeForm['displayProgrammePartenaire']; ?>
			<?php echo __("Programmes soutenus par le partenaire {partner}", array(
				'{partner}' => $partenaire->getTitle()
			)) ?>
		</td>
    <?php endif; ?>
		<td colspan="2" class="label">
      <input type="submit" class="button medium green" value="Actualiser" />
      <?php echo $mapModeForm->renderHiddenFields(); ?>
		</td>
	</tr>
</table>
</form>
