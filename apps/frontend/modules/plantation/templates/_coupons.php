<?php use_helper('Date'); ?>

<div class="module">
	<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	<p class="title little indent">
		<?php echo __("Coupons non utilisés ({number})", array('{number}' => sizeof($coupons))) ?>
	</p>
	<div class="content scrollableWrapper">
		<?php if(sizeof($coupons) > 6) : ?>
		<center>
			<span class="button white maxWidth slideUp">
				<img src="/images/icons/top.png" alt="Haut" />
			</span>
		</center>
		<?php endif; ?>

		<ul class='scrollable medium'>
			<?php foreach($coupons as $coupon) : ?>
			<li>
				<span class="bigitem">
					<?php echo __("{code} [{number} arbres] Généré le {date}", array(
						'{code}' => $coupon->getCode(),
						'{number}' => $coupon->getCouponGen()->getCredit(),
						'{date}' => format_date($coupon->getCreatedAt(), 'p', $sf_user->getCulture()),
					)) ?>
				</span>
			</li>
			<?php endforeach; ?>
		</ul>

		<?php if(sizeof($coupons) > 6) : ?>
		<center>
			<span class="button white maxWidth slideDown">
				<img src="/images/icons/bottom.png" alt="Bas" />
			</span>
		</center>
		<?php endif; ?>

		<p style="text-align:right;height: 32px;">
			<span style="line-height:32px;vertical-align:middle;"><?php echo __("Exporter : ") ?></span>
			<a href="/couponsCSV" style="float:right;margin:0;" >
				<img src="/images/icons/32x32/csv.png" alt="CSV" />
			</a>
		</p>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
