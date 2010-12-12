<div class="result">
	<table>
		<tr>
			<?php if (!empty($result['logo'])) : ?>
			<td class="affiliate-logo"><?php echo html_entity_decode($result['logo']); ?></td>
			<?php endif; ?>
			<td class="affiliate-content"><?php echo html_entity_decode($result['html']); ?></td>
			<td class="affiliate-gains">
				<h3><?php echo __("Gains :"); ?></h3>
				<p><?php echo html_entity_decode($result['gains']); ?></p>
			</td>
		</tr>
	</table>
</div>