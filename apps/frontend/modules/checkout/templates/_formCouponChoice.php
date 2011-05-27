<?php echo form_tag('checkout/coupon') ?>
	<?php $first = true; foreach($products as $product) : ?>
	<?php if(!$first) {echo '<hr />';} else {$first = false;} ?>
	<div class="product">
		<img src="" alt="<?php echo __("Coupon"); ?>" />
		<p><?php echo format_number_choice(
			"(-Inf,1]Offrir un coupon d'un arbre à un ami|(1,+Inf]Offrir un coupon de {number} arbres à un ami",
			array('{number}' => $product->getCredit()),
			$product->getCredit()
		); ?></p>
		<input type="submit" class="button orange medium" name="product[<?php echo $product->getId(); ?>]" value="<?php echo __("Offrir"); ?>" />
	</div>
	<?php endforeach; ?>
	<input type="hidden" name="step" value="dest" />
</form>