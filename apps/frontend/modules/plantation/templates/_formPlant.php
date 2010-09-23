<!-- module -->
<form name="plant" action="" method="post">
	<div class="module scrollableWrapper">
		
		<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
		<p class="title indent">Planter vos arbres</p>
		
		<div class="content">
			
			<p>Vous avez <span class="nbArbresToPlantLeft"><?php echo $nbArbresToPlant ?></span> arbre(s) à planter.</p>
			
			<?php if(sizeof($programmes) > 4) : ?>
			<span class="button white fixedWidth slideUp">
				<img src="/images/icons/top.png" alt="Haut"/>
			</span>
			<?php endif; ?>

			<ul class="scrollable">
				<?php foreach($programmes as $programme) : ?>
				<li class="item">
					<?php echo $programme->getTitle(); ?>
					<span class="action">
						<input type="hidden" name="nbArbresProgrammeHidden_<?php echo $programme->getId() ?>" value="0" />
						<span class="nbTree" programme="<?php echo $programme->getId() ?>"></span>
						<button class="addTree button really-small green" programme="<?php echo $programme->getId() ?>">+</button>
						<button class="removeTree button really-small gray" programme="<?php echo $programme->getId() ?>">-</button>
					</span>
				</li>
				<?php endforeach; ?>
			</ul>

			<?php if(sizeof($programmes) > 4) : ?>
			<span class="button white fixedWidth slideDown">
				<img src="/images/icons/bottom.png" alt="Bas"/>
			</span>
			<?php endif; ?>
			
			<br />
			
			<?php if (false && ! $sf_user->isAuthenticated()): ?>
				<p>E-mail : <input type="text" name="email_user_deco" /></p>
			<?php endif; ?>
			
			<p class="center">
				<input type="submit" name="submitArbresProgramme" style="width:40%;margin:0 2px;" class="button gray" value="Planter" />
				<a href="/" style="padding:10px 20px;margin:0 2px;" class="button white" >Annuler</a>
			</p>

		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>
	
	<input type="hidden" name="plantCouponCode" value="<?php echo $coupon->getCode() ?>" />
	<input type="hidden" name="nbTreeMax" value="<?php echo $coupon->getCouponGen()->getCredit() ?>" />
	<input type="hidden" name="nbArbresToPlantLeft" value="<?php echo $coupon->getCouponGen()->getCredit() ?>" />
	
</form>
