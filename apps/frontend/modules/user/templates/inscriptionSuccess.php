<div class="module">
	<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	<p class="title indent"><?php echo __('Inscription'); ?></p>
	<div class="content" style="min-height:250px;">
		<center>
		<form action="" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
		<?php if (!$form->getObject()->isNew()): ?>
		<input type="hidden" name="sf_method" value="put" />
		
		<?php endif; ?>
			<table>
				<tbody>
					<?php echo $form->renderGlobalErrors() ?>
					<tr>
						<th><?php echo __("Nom d'utilisateur :") ?></th>
						<td>
							<?php echo $form['username']->renderError() ?>
							<?php echo $form['username'] ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __("Mot de passe :") ?></th>
						<td>
							<?php echo $form['password']->renderError() ?>
							<?php echo $form['password'] ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __("Confirmation du mot de passe :") ?></th>
						<td>
							<?php echo $form['password_bis']->renderError() ?>
							<?php echo $form['password_bis'] ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __("Adresse e-mail :") ?></th>
						<td>
							<?php echo $form['email_address']->renderError() ?>
							<?php echo $form['email_address'] ?>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" class="right">
							<?php echo $form->renderHiddenFields(false) ?>
							<input class="button small white" type="submit" value="<?php echo __('Enregistrer'); ?>" />
						</td>
					</tr>
				</tfoot>
			</table>
			
		</form>
		</center>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>


