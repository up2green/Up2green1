<?php 
	use_helper('I18N');
	include_partial('menuProfil'); 
?>

<div class="module grey" style="width:700px;float:right;">
	<div class="content center notitle">
		<form name="main" action="<?php echo url_for('user/profil'); ?>" method="post">
			<?php echo $form->renderHiddenFields(false) ?>
			<?php echo $form->renderGlobalErrors() ?>
			<!-- General -->
			<fieldset>
				<legend><?php echo __('Général'); ?></legend>
				<table class="form">
					<tbody>
						<tr>
							<td class="label"><?php echo __('Identifiant :'); ?></td>
							<td class="field"><?php echo $sf_user->getUsername(); ?></td>
						</tr>
						<tr>
							<td class="label"><?php echo __('E-Mail :'); ?></td>
							<td class="field"><?php echo $sf_user->getGuardUser()->getEmailAddress(); ?></td>
						</tr>
						<tr>
							<td class="label"><?php echo __('Crédits disponibles :'); ?></td>
							<td class="field"><?php echo $sf_user->getGuardUser()->getProfile()->getCredit(); ?></td>
						</tr>
						<tr>
							<td class="label"><?php echo __('Arbres plantés :'); ?></td>
							<td class="field"><?php echo $nbTrees; ?></td>
						</tr>
					</tbody>
				</table>
			</fieldset>
			<!-- Profil -->
			<fieldset>
				<legend><?php echo __('Profil'); ?></legend>
				<table class="form">
					<tbody>
						<tr>
							<td class="label"><?php echo $form['user']['first_name']->renderLabel() ?></td>
							<td class="field">
								<?php echo $form['user']['first_name']->renderError() ?>
								<?php echo $form['user']['first_name'] ?>
							</td>
						</tr>
						<tr>
							<td class="label"><?php echo $form['user']['last_name']->renderLabel() ?></td>
							<td class="field">
								<?php echo $form['user']['last_name']->renderError() ?>
								<?php echo $form['user']['last_name'] ?>
							</td>
						</tr>
						<tr>
							<td class="label"><?php echo $form['profil']['is_newsletter']->renderLabel() ?></td>
							<td class="field">
								<?php echo $form['profil']['is_newsletter']->renderError() ?>
								<?php echo $form['profil']['is_newsletter'] ?>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2">
								<input class="button green small" type="submit" value="<?php echo __('Enregistrer'); ?>" />
							</td>
						</tr>
					</tfoot>
				</table>
			</fieldset>
		</form>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

