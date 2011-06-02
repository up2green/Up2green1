<?php if($nbArbresToPlant < 1) : ?>
<div class="module">
	<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	<p class="title indent"><?php echo __("Planter vos arbres") ?></p>

	<div class="content">
		<p class="error"><?php echo __("Vous n'avez pas assez de crédit pour planter un arbre !") ?></p>
		<p class="error"><?php echo __("Collectez plus de crédits au fil de vos recherches grâce au moteur Up2green.") ?></p>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

<?php else : ?>

<form name="plant" action="<?php echo url_for("plantation/confirm"); ?>" method="post">
	<div class="module scrollableWrapper">
		
		<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
		<p class="title indent">
			<?php echo format_number_choice(
				"(-Inf,1]Planter votre arbre|(1,+Inf]Planter vos arbres",
				array(),
				floor($nbArbresToPlant)
			) ?>
		</p>
		
		<div class="content">
			
			<p><?php echo format_number_choice(
				"(-Inf,0]Vous n'avez pas d'arbre à planter|[1] Vous avez un arbre à planter|(1,+Inf]Vous avez {number} arbres à planter",
				array('{number}' => '<span class="nbArbresToPlantLeft">'.floor($nbArbresToPlant).'</span>'),
				floor($nbArbresToPlant)
			) ?></p>
			
			<?php if(sizeof($programmes) > 5) : ?>
			<span class="button white fixedWidth slideUp">
				<img src="/images/icons/top.png" alt="Haut"/>
			</span>
			<?php endif; ?>

			<ul class="scrollable" style="height:150px;">
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

			<?php if(sizeof($programmes) > 5) : ?>
			<span class="button white fixedWidth slideDown">
				<img src="/images/icons/bottom.png" alt="Bas"/>
			</span>
			<?php endif; ?>

			<br />
		
			<p class="center">
				<input type="submit" name="submitArbresProgramme" style="width:40%;margin:0 2px;" class="button gray" value="<?php echo __("Planter") ?>" />
				<a href="<?php echo sfConfig::get('sf_app_url_plantation') ?>" style="padding:10px 20px;margin:0 2px;" class="button white" ><?php echo __("Annuler") ?></a>
			</p>

		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>
	
	<?php if(!is_null($coupon)) : ?>
	<input type="hidden" name="code" value="<?php echo $coupon->getCode() ?>" />
	<?php endif; ?>
	
	<input type="hidden" name="nbTreeMax" value="<?php echo floor($nbArbresToPlant) ?>" />
	<input type="hidden" name="nbArbresToPlantLeft" value="<?php echo floor($nbArbresToPlant) ?>" />
	<input type="hidden" name="fromUrl" value="<?php echo $fromUrl; ?>" />
	<input type="hidden" name="redirectUrl" value="<?php echo $redirectUrl; ?>" />
</form>
<?php endif; ?>