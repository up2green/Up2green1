<p><?php echo format_number_choice(
	"(-Inf,1]Vous avez choisi un coupon d'un arbre|(1,+Inf]Vous avez choisi un coupon de {number} arbres",
	array('{number}' => $product->getCredit()),
	$product->getCredit()
); ?></p>
<?php echo form_tag('checkout/coupon') ?>
	<table class="form">
		<tbody>
			<tr>
				<td class="label"><label for="to_mail"><?php echo __("E-mail du destinataire (*) : ") ?></label></td>
				<td class="field"><input style="width:70%;" type="text" id="to_mail" name="to_mail" /></td>
			</tr>
			<tr>
				<td class="label"><label for="from_name"><?php echo __("Votre nom : ") ?></label></td>
				<td class="field"><input style="width:70%;" type="text" id="from_name" name="from_name" value="<?php echo $sf_user->getGuardUser()->getFullName() ?>" /></td>
			</tr>
			<tr>
				<td class="label"><label for="to_name"><?php echo __("Nom du destinataire : ") ?></label></td>
				<td class="field"><input style="width:70%;" type="text" id="to_name" name="to_name" /></td>
			</tr>
			</tr>
			<tr>
				<td class="label"><label for="message"><?php echo __("Votre message : ") ?></label></td>
				<td class="field"><textarea name="message" id="message" style="width:90%; height:150px;"></textarea></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input type="submit" class="button green medium" value="<?php echo __("Continuer"); ?>" />
					<?php echo link_to(__("Retour à l'étape précédente"), "checkout/coupon", array("class" => "backlink")) ; ?>
				</td>
			</tr>
		</tfoot>
	</table>

	<input type="hidden" name="step" value="buy" />
	<input type="hidden" name="product_id" value="<?php echo $product->getId() ?>" />
</form>