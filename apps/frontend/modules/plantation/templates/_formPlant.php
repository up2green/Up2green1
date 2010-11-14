<?php if($nbArbresToPlant < 1) : ?>
<div class="module">
	<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	<p class="title indent">Planter vos arbres</p>

	<div class="content">
		<p class="error">Vous n'avez pas assez de crédit pour planter un arbre !</p>
		<p class="error">Collectez plus de crédits au fil de vos recherches grâce au moteur Up2green.</p>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

<?php else : ?>

<form name="plant" action="" method="post">
	<div class="module scrollableWrapper">
		
		<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
		<p class="title indent">Planter vos arbres</p>
		
		<div class="content">
			
			<?php 
				if(!empty($errors)) {
					echo '<p class="error">'.join('</p><p class="error">', $errors).'</p>';
				} 
			?>
			
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

			<?php if(!$sf_user->isAuthenticated()) : ?>
			<hr />
			<p style="text-align: center; color: rgb(63, 111, 0); font-size: 1.1em; font-weight: bold;">Afin de recevoir une attestation, merci de remplir votre email ici :</p>
			<p>E-mail : <input type="text" name="email_user_deco" /></p>
			<?php endif; ?>
			<br />
		
			<p class="center">
				<input type="submit" name="submitArbresProgramme" style="width:40%;margin:0 2px;" class="button gray" value="Planter" />
				<a href="/" style="padding:10px 20px;margin:0 2px;" class="button white" >Annuler</a>
			</p>

		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>
	
	<?php if(!is_null($coupon)) : ?>
	<input type="hidden" name="plantCouponCode" value="<?php echo $coupon->getCode() ?>" />
	<?php endif; ?>
	
	<input type="hidden" name="nbTreeMax" value="<?php echo $nbArbresToPlant ?>" />
	<input type="hidden" name="nbArbresToPlantLeft" value="<?php echo $nbArbresToPlant ?>" />
	<input type="hidden" name="fromUrl" value="<?php echo $fromUrl; ?>" />
</form>
<?php endif; ?>