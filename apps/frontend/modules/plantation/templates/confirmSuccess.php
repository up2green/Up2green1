<div id="body">
	<!-- Column center -->
    <div id="center">
		<div class="module">
			<div class="content">
				<?php echo form_tag('plantation/plant') ?>
					<h3><?php echo __("Résumé : ") ?></h3>
					<ul class="list">
						<?php foreach($trees as $tree) : ?>
							<li style="cursor: auto;">
								<?php echo format_number_choice(
									"(-Inf,1]un arbre dans le programme {program}|(1,+Inf]{number} arbres dans le programme {program}",
									array(
										'{number}' => $tree['nombre'],
										'{program}' => $tree['programmeTitle'],
									),
									$tree['nombre']
								); ?>
								<input type="hidden" name="trees[<?php echo $tree['programmeId'] ?>]" value="<?php echo $tree['nombre'] ?>" />
							</li>
						<?php endforeach; ?>
					</ul>
				
					<?php if($sf_user->isAuthenticated()) : ?>
					<p>
						<label for="send_email"><?php echo __("Recevoir une attestation ?") ?></label>
						<input type="checkbox" id="send_email" name="send_email" />
					</p>
					<?php else : ?>
					<table class="form" style="margin: 20px 0;">
						<thead>
							<tr><td colspan="2" style="text-align: center;"><?php echo __("Si vous désirez recevoir une attestation, merci de remplir le formulaire ci-dessous :") ?></td></tr>
						</thead>
						<tbody>
							<tr>
								<td class="label"><label for="prenom_user"><?php echo __("Prénom") ?></label></td>
								<td class="field"><input type="text" id="prenom_user" name="prenom_user" /></td>
							</tr>
							<tr>
								<td class="label"><label for="nom_user"><?php echo __("Nom") ?></label></td>
								<td class="field"><input type="text" id="nom_user" name="nom_user" /></td>
							</tr>
							<tr>
								<td class="label"><label for="email_user"><?php echo __("E-mail") ?></label></td>
								<td class="field"><input type="text" id="email_user" name="email_user" /></td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="coupon" value="<?php echo $coupon->getCode() ?>" />
					<input type="hidden" name="fromUrl" value="<?php echo $fromUrl ?>" />
					<?php endif; ?>
					<p class="center">
						<input type="submit" name="confirmPlant" class="button green big" value="<?php echo __("Confirmer et planter") ?>" />
						<a href="<?php echo url_for('plantation/index') ?>" class="backlink"><?php echo __("Revenir à la plantation") ?></a>
					</p>
				</form>
			</div>
			<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
		</div>
	</div>
	<!-- Column left -->
	<div id="left">
		<?php 
		include_partial('logo');
		if(!is_null($partenaire)) {
			include_partial('formPartenaire', array('partenaire' => $partenaire));
		}
		elseif(!$sf_user->isAuthenticated()) {
			include_partial('formInscription', array());
		}
		?>
	</div>
</div>
