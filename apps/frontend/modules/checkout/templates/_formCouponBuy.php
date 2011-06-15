<?php echo form_tag('checkout/coupon') ?>
	<fieldset>
		<legend><?php echo __("Récapitulatif"); ?></legend>
		<p class="important"><?php echo format_number_choice(
			"(-Inf,1]Vous êtes sur le point d'offrir un coupon d'un arbre à {username}.|(1,+Inf]Vous êtes sur le point d'offrir un coupon de {number} arbres à {username}.",
			array(
				'{number}' => $product->getCredit(),
				'{username}' => empty ($toName) ? $toMail : $toName.' ('.$toMail.')',
			),
			$product->getCredit()
		);?></p>
		<p><?php echo __("Ce coupon vous sera facturé {price}{currency} + la commission du prestataire de paiement ci-dessous.", array(
			'{price}' => $product->getPrix(),
			'{currency}' => '€',
		)); ?></p>
		<p style="color: #666666; font-size: 0.9em; font-style: italic; padding: 15px 0 0"><?php echo __("Les coupons de plantations sont valables {number} jours après leur création.", array(
				'{number}' => sfConfig::get("app_validite_coupon")
		)) ?></p>
		<p style="color: #666666; font-size: 0.9em; font-style: italic; padding: 5px 5px 15px;"><?php echo __("Au delà de cette date de validité, l'Association Up2green Reforestation choisira le(s) programme(s) financé(s)") ?></p>

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