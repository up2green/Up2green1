<?php echo form_tag('checkout/credit') ?>
	<?php $first = true; foreach($payments as $payment) : ?>
	<?php if(!$first) {echo '<hr />';} else {$first = false;} ?>
	<div class="payement-type">
		<table style="width:100%">
			<tr>
				<td><img src="/images/payment/<?php echo $payment ?>.png" alt="<?php echo $payment ?>" /></td>
				<td style="vertical-align: middle;"><input type="submit" class="button orange medium" name="payment[<?php echo $payment ?>]" value="<?php echo __("Acheter") ?>" /></td>
			</tr>
		</table>
	</div>
	<?php endforeach; ?>

	<input type="hidden" name="step" value="final" />
	<input type="hidden" name="credit" value="<?php echo $credit ?>" />
</form>
