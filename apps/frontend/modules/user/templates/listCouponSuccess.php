<?php 
	use_helper('Date');
	include_component('user', 'menuProfil');
?>

<div class="module grey" style="width:700px;float:right;">
	<div class="content center notitle">
		
		<?php if(!count($pager)) :?>
		<p><?php echo __("Vous n'avez pas encore acheté de coupon.") ?></p>
		<?php else :?>
		<p style="color: #666666; font-size: 0.9em; font-style: italic;"><?php echo __("Les coupons de plantations sont valables {number} jours après leur création.", array(
				'{number}' => sfConfig::get("app_validite_coupon")
		)) ?></p>
		<p style="color: #666666; font-size: 0.9em; font-style: italic; padding: 5px 5px 15px;"><?php echo __("Au delà de cette date de validité, l'Association Up2green Reforestation choisira le(s) programme(s) financé(s)") ?></p>
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
			<?php include_partial('html/pager', array(
					'pager' => $pager,
					'url_for' => 'user_coupon'
			)); ?>
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
			<a href="<?php echo url_for('@couponsCSV?format=csv') ?>" >
				<img src="/images/icons/16x16/csv.png" alt="CSV" tooltiped="true" title="<?php echo __("CSV pour OpenOffice"); ?>" />
			</a>
			<a href="<?php echo url_for('@couponsCSV?format=xls') ?>" style="float:right;margin:0;" >
				<img src="/images/icons/16x16/xls.png" alt="XLS" tooltiped="true" title="<?php echo __("CSV pour Microsoft Excel"); ?>" />
			</a>
		</div>
		<?php endif; ?>
		
		<?php endif; ?>
		
		
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>