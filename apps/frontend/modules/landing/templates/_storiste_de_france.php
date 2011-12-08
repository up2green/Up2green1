<?php
use_stylesheet('marketing/sdf.css?v='.sfConfig::get('app_media_version'));
$nbArbres = str_pad($nbArbres, 5, "0", STR_PAD_LEFT);
?>

<div id="content">

<h1 id="header"><img src="/images/marketing/SdF/accroche.png" alt="Offrez 1 arbre à la terre" /></h1>
<table id="content-inner">
	<tr>
		<td id="content-inner-left">
			<img style="height: 250px;" src="/images/marketing/SdF/logo-sdf.png" alt="Logo Storistes de France"/>
			<p style="text-align: center; font-size: 18px; margin-top: 20px; padding: 10px;">
				Déjà
			</p>
			<div id="compteur">
				<div class="chiffre"><?php echo $nbArbres[0] ?></div>
                <div class="chiffre"><?php echo $nbArbres[1] ?></div>
                <div class="chiffre"><?php echo $nbArbres[2] ?></div>
                <div class="chiffre"><?php echo $nbArbres[3] ?></div>
                <div class="chiffre"><?php echo $nbArbres[4] ?></div>
			</div>
			<p style="padding: 5px; text-align: center; font-size: 18px; line-height: 21px;">
				arbres plantés avec Storistes de France
			</p>
		</td>
		<td id="content-inner-center">
			<h2 class="accroche">Faites grandir la fôret avec Storistes de France !</h2>
			<h3 class="accroche">Devenons ensemble acteurs de la reforestation et choisissez où planter votre arbre sur la Planète.</h3>
			<!-- module content -->
			<div class="module">
				<div class="content">
					<h3>Entrez votre code sécurisé pour accéder à la plate forme de plantation et choisir votre programme de reforestation.</h3>

					<form action="<?php echo sfConfig::get('app_url_plantation'); ?>" method="post">
						<p>
							<input type="text" name="code" placeholder="Numéro de coupon" />
							<input type="submit" class="button green medium" name="numCouponToUse" value="Plantez" />
							<input type="hidden" name="fromUrl" value="<?php echo sfConfig::get('app_url_plantation'); ?>landing/plantation/sdf/1arbre" />
							<input type="hidden" name="redirectUrl" value="<?php echo sfConfig::get('app_url_plantation'); ?>landing/map/sdf" />
						</p>
					</form>

				</div>
				<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
			</div>
		</td>
		<td id="content-inner-right">
			<a target="_blank" href="<?php echo sfConfig::get('app_url_moteur') ?>">
				<img src="/images/logo/200x200/earth-hand.png" alt="Logo Up2green"/>
			</a>
		</td>
	</tr>
</table>
<div class="clear"></div>
	

</div>