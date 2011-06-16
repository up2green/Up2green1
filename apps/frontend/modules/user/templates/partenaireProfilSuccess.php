<?php include_component('user', 'menuProfil'); ?>

<div class="module purple" style="width:700px;float:right;">
	<div class="content center notitle">
		<?php echo form_tag('@partenaire_profil', array('enctype' => 'multipart/form-data')) ?>
			<?php echo $form->renderHiddenFields(false) ?>
			<?php echo $form->renderGlobalErrors() ?>
			<!-- General -->
			<fieldset>
				<legend><?php echo __('Informations générales'); ?></legend>
				<table class="form no-field-width">
					<tbody>
						<tr>
							<td class="label"><?php echo __('Nom'); ?></td>
							<td class="field"><?php echo $form['title']; ?></td>
						</tr>
						<tr>
							<td class="label"><?php echo __('Site internet'); ?></td>
							<td class="field"><?php echo $form['url']; ?></td>
						</tr>
						<tr>
							<td class="label"><?php echo __('Accroche'); ?></td>
							<td class="field"><?php echo $form['accroche']; ?></td>
						</tr>
					</tbody>
				</table>
			</fieldset>
			<!-- Logo -->
			<fieldset>
				<legend><?php echo __('Votre logo'); ?></legend>
				<table class="form no-field-width">
					<tbody>
						<tr>
							<td class="label"><?php echo __('Logo'); ?></td>
							<td class="field"><?php echo $form['logo']; ?></td>
						</tr>
					</tbody>
				</table>
			</fieldset>
			<p class="right">
				<input type="submit" class="button green medium" value="<?php echo __("Enregistrer") ?>" />
			</p>
		</form>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>