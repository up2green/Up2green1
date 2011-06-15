<?php include_component('user', 'menuProfil'); ?>

<div class="module purple" style="width:700px;float:right;">
	<div class="content center notitle">
		<?php echo form_tag('@partenaire_profil_page', array('enctype' => 'multipart/form-data')) ?>
			<?php echo $form->renderHiddenFields(false) ?>
			<?php echo $form->renderGlobalErrors() ?>
			<?php echo $form['page']; ?>
			<p class="right" style="margin-top:20px;">
				<input type="submit" class="button green medium" value="<?php echo __("Enregistrer") ?>" />
			</p>
		</form>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>