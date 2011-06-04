<p>
	<?php echo __('1 crédit = {prix}{devise}', array(
		'{prix}' => sfConfig::get('app_prix_credit'),
		'{devise}' => '€'
	)); ?>
</p>
<?php echo form_tag('checkout/credit') ?>
	<fieldset>
		<legend><?php echo __('Crédit'); ?></legend>
		<table class="form">
			<tbody>
				<tr>
					<td class="label"><?php echo __('Nombre de crédit à acheter :'); ?></td>
					<td class="field"><input type="text" name="credit" /></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">
						<input class="button green small" type="submit" name="submit_password" value="<?php echo __("Passer à l'étape suivante"); ?>" />
					</td>
				</tr>
			</tfoot>
		</table>
	</fieldset>
	<input type="hidden" name="step" value="buy" />
</form>