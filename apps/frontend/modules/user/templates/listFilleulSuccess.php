<?php 
	use_helper('Date');
	include_partial('menuProfil');
?>

<div class="module grey" style="width:700px;float:right;">
	<div class="content center notitle">
		
		<?php if(!count($pager)) :?>
		<p><?php echo __("Vous n'avez pas encore de filleul, {lien}parrainez vos amis dès maintenant{/lien} pour planter encore plus d'arbres !", array(
				'{lien}' => '<a class="read_more" href="'.url_for('@user_invite_filleul').'">',
				'{/lien}' => '</a>'
		)) ?></p>
		<?php else :?>
		
		<table class="table">
			<thead>
				<tr>
					<th><?php echo __("E-Mail"); ?></th>
					<th><?php echo __("Enregistré ?"); ?></th>
					<th><?php echo __("Gains grâce au filleul"); ?></th>
					<th><?php echo __("Date d'inscription"); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($filleuls as $filleul) : ?>
				<tr>
					<td><?php echo $filleul->getEmailAddress() ?></td>
					<td><img src="/sfDoctrinePlugin/images/<?php echo $filleul->getFilleulId() ? 'tick' : 'delete'; ?>.png" alt="<?php echo $filleul->getFilleulId() ? __("Oui") : __("Non"); ?>" /></td>
					<td><?php echo $filleul->getFilleulId() ? $filleul->getFilleul()->getTotalGain() * sfConfig::get('app_gain_parrain') : '-' ?></td>
					<td><?php echo $filleul->getFilleulId() ? format_date($filleul->getFilleul()->getCreatedAt(), 'p', $sf_user->getCulture()) : '-' ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			
			<?php if ($pager->haveToPaginate()): ?>
			<?php include_partial('html/pager', array(
					'pager' => $pager,
					'url_for' => 'user_filleul'
			)); ?>
			<?php endif; ?>
		</table>
		<div class="pagination_desc">
			<strong><?php echo count($pager) ?></strong> <?php echo format_number_choice("(-Inf,1]filleul|(1,+Inf]filleuls", array(), count($pager)) ?>
			<?php if ($pager->haveToPaginate()): ?>
				- <?php echo __("page {current}/{total}", array(
						'{current}' => $pager->getPage(),
						'{total}' => $pager->getLastPage()
				)) ?>
			<?php endif; ?>
		</div>
		
		
		<?php endif; ?>
		
		
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>