<?php echo form_tag('checkout/credit') ?>
	<fieldset>
		<legend><?php echo __("Récapitulatif"); ?></legend>
		<p><?php echo __("Vous êtes sur le point de créditer votre compte de {number} crédits pour un prix de {price}{currency} (<em>+ le prix de la commission sur la transaction demandé par le service de facturation ci-dessous</em>).", array(
				'{number}' =>$credit ,
				'{price}' => $prix,
				'{currency}' => '€',
		)); ?></p>
	</fieldset>
	<fieldset>
		<legend><?php echo __("Mode de paiement"); ?></legend>
		<?php include_partial('checkout/formModePaiement', array(
			'payments' => $payments,
			'commissions' => $commissions
		)); ?>
	</fieldset>
	<p class="right">
		<?php echo link_to(__("Retour à l'étape précédente"), "checkout/credit", array("class" => "backlink")) ; ?>
		<input type="submit" class="button green medium" value="<?php echo __("Procéder au paiement") ?>" />
	</p>

	<input type="hidden" name="step" value="final" />
	<input type="hidden" name="credit" value="<?php echo $credit ?>" />
</form>
