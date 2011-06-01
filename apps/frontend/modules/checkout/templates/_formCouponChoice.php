<p class="important"><?php echo __("Up2green vous offre la possibilité d'acheter un coupon contenant un code qu'un de vos ami pourra utiliser sur la plateforme de reforestation. Vous pourrez accompagner ce cadeau par un message personnel."); ?></p>
<?php echo form_tag('checkout/coupon') ?>
	<fieldset>
		<legend><?php echo __('Choix du coupon'); ?></legend>
		<?php $first = true; foreach($products as $product) : ?>
		<?php if(!$first) {echo '<hr />';} else {$first = false;} ?>
		<table style="width:100%">
			<tr>
				<td style="vertical-align: middle;">
					<input id="product-<?php echo $product->getId() ?>" type="radio" name="product" value="<?php echo $product->getId() ?>" />
				</td>
				<td style="vertical-align: middle;">
					<label style="cursor:pointer" for="product-<?php echo $product->getId() ?>">
						<?php echo format_number_choice(
							"(-Inf,1]Offrir un coupon d'un arbre à un ami|(1,+Inf]Offrir un coupon de {number} arbres à un ami",
							array('{number}' => $product->getCredit()),
							$product->getCredit()
						); ?>
					</label>
				</td>
			</tr>
		</table>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button green medium" value="<?php echo __("Continuer"); ?>" />
	<input type="hidden" name="step" value="dest" />
</form>