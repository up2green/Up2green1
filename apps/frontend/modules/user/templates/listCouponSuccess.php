<?php 
	use_helper('Date');
	include_partial('menuProfil');
//var_dump($form['user']['last_name']);
?>

<div class="module grey" style="width:700px;float:right;">
	<div class="content center notitle">
		
		<?php if(!count($pager)) :?>
		<p><?php echo __("Vous n'avez pas encore acheté de coupon.") ?></p>
		<?php else :?>
		
		<table class="table">
			<thead>
				<tr>
					<th><?php echo __("Numéro"); ?></th>
					<th><?php echo __("Nombre d'arbres"); ?></th>
					<th><?php echo __("Utilisé ?"); ?></th>
					<th><?php echo __("Date d'utilisation"); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($coupons as $coupon) : ?>
				<tr>
					<td><?php echo $coupon->getCode() ?></td>
					<td><?php echo $coupon->getCouponGen()->getCredit() ?></td>
					<td><img src="/sfDoctrinePlugin/images/<?php echo $coupon->getIsActive() ? 'delete' : 'tick'; ?>.png" alt="<?php echo $coupon->getIsActive() ? __("Non") : __("Oui"); ?>" /></td>
					<td><?php echo !$coupon->getIsActive() ? __("Utilisé le {date} sur les programmes : {programs}", array(
						'{date}' => format_date($coupon->getUsedAt(), 'p', $sf_user->getCulture()),
						'{programs}' => $coupon->getFormatedListProgrammes(),
					)) : '-'; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			
			<?php if ($pager->haveToPaginate()): ?>
			<tfoot class="pagination">
				<tr>
					<td colspan="4">
						<a href="<?php echo url_for('user_coupon') ?>?page=1">
							<img src="/sfDoctrinePlugin/images/first.png" alt="<?php echo __("Première page") ?>" />
						</a>

						<a href="<?php echo url_for('user_coupon') ?>?page=<?php echo $pager->getPreviousPage() ?>">
							<img src="/sfDoctrinePlugin/images/previous.png" alt="<?php echo __("Page précédente") ?>" />
						</a>

						<?php foreach ($pager->getLinks() as $page): ?>
							<?php if ($page == $pager->getPage()): ?>
								<?php echo $page ?>
							<?php else: ?>
								<a href="<?php echo url_for('user_coupon') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
							<?php endif; ?>
						<?php endforeach; ?>

						<a href="<?php echo url_for('user_coupon') ?>?page=<?php echo $pager->getNextPage() ?>">
							<img src="/sfDoctrinePlugin/images/next.png" alt="<?php echo __("Page suivante") ?>" />
						</a>

						<a href="<?php echo url_for('user_coupon') ?>?page=<?php echo $pager->getLastPage() ?>">
							<img src="/sfDoctrinePlugin/images/last.png" alt="<?php echo __("Dernière page") ?>" />
						</a>
					</td>
				</tr>				
			</tfoot>
			<?php endif; ?>
		</table>
		<div class="pagination_desc">
			<strong><?php echo count($pager) ?></strong> <?php echo format_number_choice("(-Inf,1]coupon|(1,+Inf]coupons", array(), count($pager)) ?>
			<?php if ($pager->haveToPaginate()): ?>
				- <?php echo __("page {current}/{total}", array(
						'{current}' => $pager->getPage(),
						'{total}' => $pager->getLastPage()
				)) ?>
			<?php endif; ?>
		</div>
		
		<?php if(!empty($partenaire)) :?>
		<div class="export_wrapper">
			<span style="line-height:16px;vertical-align:middle;padding-right:5px;"><?php echo __("Exporter : ") ?></span>
			<a href="<?php echo url_for('couponsCSV') ?>" style="float:right;margin:0;" >
				<img src="/images/icons/16x16/csv.png" alt="CSV" />
			</a>
		</div>
		<?php endif; ?>
		
		<?php endif; ?>
		
		
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>