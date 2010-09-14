<div class="module purple">
    <img class="title middle left" src="/images/module/purple/icon/icon-partenaires.png" alt="" />
    <p class="title indent"><?php echo $partenaire->getTitle() ?></p>
    <div class="content">
			<?php 
				if(
					$partenaire->getLogo() != '' && 
					file_exists(sfConfig::get('sf_upload_dir').'/partenaire/'.$partenaire->getLogo())
				) : 
			?> 
			<img class="organisme-image" src="/uploads/partenaire/<?php echo $partenaire->getLogo(); ?>" alt="Logo">
			<?php endif; ?>
			<p><?php echo html_entity_decode($partenaire->getAccroche()); ?></p>
			<p class="center">
				<?php 
					if(
						$sf_user->isAuthenticated() &&
						$view === 'listeCouponsPartenaires' &&
						!is_null($partenaire)
					) :
				?>
					<a href="/" class="button green">Retour à la Carte</a>
				<?php else : ?>
					<a href="/listeCouponsPartenaires" class="button purple">Voir mes coupons</a>
				<?php endif; ?>
			</p>
    </div>
    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
