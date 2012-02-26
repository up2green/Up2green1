<div class="module">
	<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	<p class="title indent"><?php echo __('Inscription'); ?></p>
	<div class="content" style="min-height:250px;">
		<center>
		<form action="" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
			<fieldset>
				<legend><?php echo __('Vos informations'); ?></legend>
				<table class="form">
					<tbody>
						<tr>
							<td class="label"><?php echo __("Nom d'utilisateur (*) :") ?></th>
							<td class="field">
								<?php 
									if($form['username']->hasError() && $form['username']->getError() == 'An object with the same "username" already exist.') {
										echo '<ul class="error_list"><li>'.__('Un utilisateur porte déjà ce nom').'</li></ul>';
									}
								?>
								<?php echo $form['username'] ?>
							</td>
						</tr>
						<tr>
							<td class="label"><?php echo __("Mot de passe (*) :") ?></th>
							<td class="field">
								<?php echo $form['password']->renderError() ?>
								<?php echo $form['password'] ?>
							</td>
						</tr>
						<tr>
							<td class="label"><?php echo __("Confirmation du mot de passe (*) :") ?></th>
							<td class="field">
								<?php echo $form['password_bis']->renderError() ?>
								<?php echo $form['password_bis'] ?>
							</td>
						</tr>
						<tr>
							<td class="label"><?php echo __("Adresse e-mail (*) :") ?></th>
							<td class="field">
								<?php echo $form['email_address']->renderError() ?>
								<?php echo $form['email_address'] ?>
							</td>
						</tr>
						<tr>
							<td class="label"><?php echo __("Prénom :") ?></th>
							<td class="field">
								<?php echo $form['first_name']->renderError() ?>
								<?php echo $form['first_name'] ?>
							</td>
						</tr>
						<tr>
							<td class="label"><?php echo __("Nom :") ?></th>
							<td class="field">
								<?php echo $form['last_name']->renderError() ?>
								<?php echo $form['last_name'] ?>
							</td>
						</tr>
						<tr>
							<td class="label"><?php echo __("Recevoir les newsletter :") ?></th>
							<td class="field">
								<input type="checkbox" name="is_newsletter" value="1" checked="checked" />
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2" class="label right">
								<?php echo __("(*) : Champs obligatoires"); ?>
							</td>
						</tr>
					</tfoot>
				</table>
			</fieldset>
			<h3 class="green"><?php echo __("En parrainant vos amis, vous aidez l’Association à être connue et vous collectez ensuite de façon systématique {number}% des arbres qu’ils gagnent au fil de leurs recherches !", array(
					'{number}'=> sfConfig::get('app_gain_parrain') * 100
			)); ?></h3>
			<?php include_partial('formInviteFilleulContent', array('withButton' => false)); ?>
			<?php echo $form->renderHiddenFields(false) ?>
			<?php if (!$form->getObject()->isNew()): ?>
			<input type="hidden" name="sf_method" value="put" />
			<?php endif; ?>
			<p class="right">
				<input class="button small green" type="submit" value="<?php echo __('Enregistrer'); ?>" />
			</p>
		</form>
		</center>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>


