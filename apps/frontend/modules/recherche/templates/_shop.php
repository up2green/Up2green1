<?php
$treeImg = '<img src="/images/icons/16x16/arbre.png" alt="Arbre(s)" />';

$from = $result['remun_min']/2;
$to = $result['remun_max']/2;

if($result['remun_type'] === 'pourcent') {
	$from = $from * 30 / (sfConfig::get('app_prix_arbre') * 100);
	$to = $to * 30 / (sfConfig::get('app_prix_arbre') * 100);
}

$from = (floor($from) == $from) ? (int)$from : number_format($from, 2, ',', ' ');
$to = (floor($to) == $to) ? (int)$to : number_format($to, 2, ',', ' ');

if($from !== $to) {
	$gain = __("de {from} à {to}", array(
		'{from}' => "<strong>".$from."</strong>",
		'{to}' => "<strong>".$to."</strong> ".$treeImg,
	));
}
else {
	$gain = $from.' '.$treeImg;
}

if($result['remun_type'] === 'pourcent') {
	$gain = __("{gain} pour 30€ d'achat", array('{gain}' => $gain));
}

?>

<div class="result">
	<table>
		<tr>
			<?php if (!empty($result['logo'])) : ?>
			<td class="affiliate-logo"><?php echo html_entity_decode($result['logo']); ?></td>
			<?php endif; ?>
			<td class="affiliate-content"><?php echo html_entity_decode($result['html']); ?></td>
			<td class="affiliate-gains">
				<h3><?php echo __("Gains :"); ?></h3>
				<p title="<?php echo __("L'obtention des arbres grâce aux sites marchand (liens Achats) est soumis à un délai d'environ une semaine.") ?>">
					<?php echo $gain; ?>
				</p>
			</td>
		</tr>
	</table>
</div>