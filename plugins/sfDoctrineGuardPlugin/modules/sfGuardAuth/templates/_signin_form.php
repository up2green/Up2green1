<div class="module">
	<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	<p class="title indent">Inscription</p>
	<div class="content" style="min-height:250px;">
		<center>

			<?php use_helper('I18N') ?>

			<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
				<table class="form" style="width:50%;">
						<tbody>
					<?php echo $form->renderGlobalErrors() ?>
					<tr>
						<th><?php echo $form['username']->renderLabel() ?></th>
						<td>
							<?php echo $form['username']->renderError() ?>
							<?php echo $form['username'] ?>
						</td>
					</tr>
					<tr>
						<th><?php echo $form['password']->renderLabel() ?></th>
						<td>
							<?php echo $form['password']->renderError() ?>
							<?php echo $form['password'] ?>
						</td>
					</tr>
				</tbody>
					<tfoot>
						<tr>
							<td colspan="2">
								<?php echo $form->renderHiddenFields(false) ?>
							<input class="button small green" type="submit" value="Se connecter" />
								
								<?php $routes = $sf_context->getRouting()->getRoutes() ?>
								<?php if (isset($routes['sf_guard_forgot_password'])): ?>
									<a class="button small gray" href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Mot de passe oublié ?', null, 'sf_guard') ?></a>
								<?php endif; ?>

								<?php if (isset($routes['sf_guard_register'])): ?>
									&nbsp; <a style="padding:0.4em 1em;" class="button small gray" href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('S \'inscrire', null, 'sf_guard') ?></a>
								<?php endif; ?>
							</td>
						</tr>
					</tfoot>
				</table>
			</form>

		</center>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

