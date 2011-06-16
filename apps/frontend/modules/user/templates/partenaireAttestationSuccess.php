<?php include_component('user', 'menuProfil'); ?>

<div class="module purple" style="width:700px;float:right;">
	<div class="content center notitle">
		
		<?php if(is_null($partenaire->getAttestation()) || $partenaire->getAttestation() == '') : ?>
		<p class="important"><?php echo __("Vous utilisez actuelement l'attestation par défaut. Vous pouvez la modifier ci-dessus."); ?></p>
		<?php endif; ?>
		<p class="important"><?php echo __("Attention, cette image doit obligatoirement être au format A4 paysage (soit très exactement 842px de large et 595px de hauteur) et ne pas dépasser 1Mo. Ces contraintes sont très importantes pour gérer la  construction de l'attestation."); ?></p>
		<p class="important"><?php echo __("Ce fond d'attestation est remplis par le nom de l'utilisateur, la localisation des arbres qu'il a plantés ainsi que la date de génération de l'attestation. Laissez donc de la place pour le texte. (Demandez nous des codes de tests si vous avez besoin de tester le rendu)"); ?></p>
		
		<?php echo form_tag('@partenaire_profil_attestation', array('enctype' => 'multipart/form-data')) ?>
			<?php echo $form->renderHiddenFields(false) ?>
			<?php echo $form->renderGlobalErrors() ?>
			<?php echo $form['attestation']; ?>
			<p class="right">
				<input type="submit" class="button green medium" value="<?php echo __("Enregistrer") ?>" />
			</p>
		</form>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>