<?php include_partial('menuProfil'); ?>
<div class="module grey" style="width:700px;float:right;">
	<div class="content center notitle">
		<?php if(!empty ($alreadyUserOrFilleul)) : ?>
		<p class="error">
			<?php echo format_number_choice("(-Inf,1]Le contact suivant est déjà membres up2green ou a déjà reçu une invitation : |(1,+Inf]Les contacts suivant sont déjà membres up2green ou ont déjà reçu une invitation : ", array(), count($alreadyUserOrFilleul)); ?>
		</p>
		<ul>
			<?php foreach ($alreadyUserOrFilleul as $email) {
				echo "<li>".$email."</li>";
			} ?>
		</ul>
		<?php endif; ?>
		<h3 class="green"><?php echo __("Grâce au système de parainage d'up2green, consolider votre geste écologique en plantant encore plus d'arbres. Pour chacun de vos filleuls, vous gagnerez automatiquement {number}% de ses gains en crédits arbre!", array(
				'{number}'=> sfConfig::get('app_gain_parrain') * 100
		)); ?></h3>
		<form name="invite" action="<?php echo url_for('user_invite_filleul'); ?>" method="post">
			<?php include_partial('formInviteFilleulContent'); ?>
		</form>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

