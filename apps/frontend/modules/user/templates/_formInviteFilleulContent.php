<fieldset>
	<legend><?php echo __('Parrainer des amis'); ?></legend>
	<table class="form">
		<tbody>
			<tr>
				<td class="label"><?php echo __('E-Mail :'); ?></td>
				<td class="field"><input type="text" style="width: 100%" name="filleul[1]" placeholder="<?php echo __("Entrez l'addresse email de votre contact ici") ?>" /></td>
			</tr>
			<tr>
				<td class="label"><?php echo __('E-Mail :'); ?></td>
				<td class="field"><input type="text" style="width: 100%" name="filleul[2]" placeholder="<?php echo __("Entrez l'addresse email de votre contact ici") ?>" /></td>
			</tr>
			<tr>
				<td class="label"><?php echo __('E-Mail :'); ?></td>
				<td class="field"><input type="text" style="width: 100%" name="filleul[3]" placeholder="<?php echo __("Entrez l'addresse email de votre contact ici") ?>" /></td>
				<td class="info"><img class="add-line" src="/images/icons/16x16/plus.png" alt="<?php echo __("Ajouter une adresse"); ?>" /></td>
			</tr>
		</tbody>
		<?php if(!isset($withButton) || $withButton) : ?>
		<tfoot>
			<tr>
				<td colspan="2">
					<input class="button green small" type="submit" name="submit_password" value="<?php echo __('Envoyer les invitations'); ?>" />
				</td>
			</tr>
		</tfoot>
		<?php endif; ?>
	</table>
</fieldset>