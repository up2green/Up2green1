<?php use_helper('Date'); ?>

<div class="module scrollableWrapper">
	<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	<p class="title little indent">
		<?php echo __("Coupons utilisés ({number})", array('{number}' => sizeof($coupons))) ?>
	</p>
	<div class="content">
		<?php if(sizeof($coupons) > 6) : ?>
		<span class="button white maxWidth slideUp">
			<img src="/images/icons/top.png" alt="Haut"/>
		</span>
		<?php endif; ?>

		<ul class='scrollable medium'>
			<?php foreach($coupons as $coupon) : ?>
			<li>
				<span class="bigitem">
					<?php echo __("{code} [{number} arbres] Utilisé le {date} sur les programmes : {programs}", array(
						'{code}' => $coupon->getCode(),
						'{number}' => $coupon->getCouponGen()->getCredit(),
						'{date}' => format_date($coupon->getUsedAt(), 'p', $sf_user->getCulture()),
						'{programs}' => $coupon->getFormatedListProgrammes(),
					)) ?>
				</span>
			</li>
			<?php endforeach; ?>
		</ul>

		<?php if(sizeof($coupons) > 6) : ?>
		<span class="button white maxWidth slideDown">
			<img src="/images/icons/bottom.png" alt="Bas"/>
		</span>
		<?php endif; ?>

		<p style="text-align:right;height: 32px;">
			<span style="line-height:32px;vertical-align:middle;"><?php echo __("Exporter : ") ?></span>
			<a href="/couponsUsedCSV" style="float:right;margin:0;" >
				<img src="/images/icons/32x32/csv.png" alt="CSV" />
			</a>
		</p>

	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>