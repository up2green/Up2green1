<?php $first = true; foreach($payments as $payment) : ?>
<?php if(!$first) {echo '<hr />';} ?>
<div class="payement-type">
	<table style="width:100%">
		<tr>
			<td style="vertical-align: middle;">
				<input <?php if($first) {echo 'checked="checked" ';} ?>id="payment-<?php echo $payment ?>" type="radio" name="payment" value="<?php echo $payment ?>" />
			</td>
			<td><label style="cursor:pointer" for="payment-<?php echo $payment ?>">
				<img src="/images/payment/<?php echo $payment ?>.png" alt="<?php echo $payment ?>" />
			</label></td>
			<td style="vertical-align: middle;">
				<?php echo __("(commission de {price}{currency})", array(
						'{price}' => round($commissions[$payment], 2),
						'{currency}' => '€',
				)) ?>
			</td>
		</tr>
	</table>
</div>
<?php $first = false; endforeach; ?>