<?php use_helper('I18N') ?>
<div class="module">
	<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	<p class="title indent">Inscription</p>
	<div class="content" style="min-height:250px;">
		<center>
			<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
				<table class="form" style="width:50%;">
						<tbody>
					<tr>
						<td class="label"><?php echo $form['username']->renderLabel() ?></th>
						<td class="field">
							<?php echo $form['username']->renderError() ?>
							<?php echo $form['username'] ?>
						</td>
					</tr>
					<tr>
						<td class="label"><?php echo $form['password']->renderLabel() ?></th>
						<td class="field">
							<?php echo $form['password']->renderError() ?>
							<?php echo $form['password'] ?>
						</td>
					</tr>
				</tbody>
					<tfoot>
						<tr>
							<td colspan="2">
								<?php echo $form->renderHiddenFields(false) ?>
								<input class="button small green" type="submit" value="<?php echo __('Se connecter') ?>" />
								&nbsp; <a style="padding:0.4em 1em;" class="button small gray" href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __("S'inscrire") ?></a>
								&nbsp; <a style="padding:0.4em 1em;" class="button small gray" href="<?php echo url_for('@user_forgot_password') ?>"><?php echo __('Mot de passe oublié ?') ?></a>
							</td>
						</tr>
					</tfoot>
				</table>
			</form>

		</center>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

