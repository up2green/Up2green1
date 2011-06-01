<?php echo form_tag('checkout/coupon') ?>
	<fieldset>
		<legend><?php echo __("Récapitualitf"); ?></legend>
		<p class="important"><?php echo __("Vous êtes sur le point d'offrir un coupon de {number} arbres à {username}.", array(
			'{number}' => $product->getCredit(),
			'{username}' => empty ($toName) ? $toMail : $toName.' ('.$toMail.')',
		)); ?></p>
		<p><?php echo __("Ce coupon vous sera facturé {price}{currency} + la commission du prestataire de paiement ci-dessous.", array(
			'{price}' => $product->getPrix(),
			'{currency}' => '€',
		)); ?></p>
		<?php if (!empty ($message)) : ?>
		<p><?php echo __("Le message suivant sera ajouté au coupon :"); ?></p>
		<blockquote class="quote">
			<?php echo $message ?>
		</blockquote>
		<?php endif; ?>
	</fieldset>
	<fieldset>
		<legend><?php echo __("Mode de paiement"); ?></legend>
		<?php include_partial('checkout/formModePaiement', array(
			'payments' => $payments,
			'commissions' => $commissions
		)); ?>
	</fieldset>
	<p class="right">
		<?php echo link_to(__("Retour à l'étape précédente"), "checkout/coupon", array("class" => "backlink")) ; ?>
		<input type="submit" class="button green medium" value="<?php echo __("Procéder au paiement") ?>" />
	</p>

	<input type="hidden" name="step" value="final" />
	<input type="hidden" name="product_id" value="<?php echo $product->getId() ?>" />
</form>