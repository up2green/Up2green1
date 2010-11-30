<?php
	$totalTrees = (int)$totalTrees + 8847;
?>

<div id="body">

	<form id="searchForm" name="recherche" action="" method="post">
		
		<div class="search">
			<input type="hidden" id="hidden_text_search" name="hidden_text_search" value="<?php echo $textSearch ?>" />
			<input type="hidden" id="hidden_moteur_search" name="hidden_moteur_search" value="<?php echo $moteur ?>" />
			<input type="text" id="recherche_text" name="recherche_text" size="65" value="<?php echo $textSearch ?>" />
			<input type="submit" id="recherche_submit" name="recherche_submit" value="Rechercher" class="button white small" />
		</div>

		<div class="more_search">
			<div class="filtres">
				<a href="javascript:" onclick="changeMoteur(<?php echo SearchEngine::WEB ?>);">
					<div id="recherches<?php echo SearchEngine::WEB ?>" class="onglet_recherches <?php echo ($moteur == SearchEngine::WEB ? "onglet_selected" : "") ?>">
						<div id="left<?php echo SearchEngine::WEB ?>" class="onglet_left <?php echo ($moteur == SearchEngine::WEB ? "onglet_selected" : "") ?>"></div>
						<div id="middle<?php echo SearchEngine::WEB ?>" class="onglet_middle <?php echo ($moteur == SearchEngine::WEB ? "onglet_selected" : "") ?>">Web</div>
						<div id="right<?php echo SearchEngine::WEB ?>" class="onglet_right <?php echo ($moteur == SearchEngine::WEB ? "onglet_selected" : "") ?>"></div>
					</div>
				</a>
				<a href="javascript:" onclick="changeMoteur(<?php echo SearchEngine::NEWS ?>);">
					<div id="recherches<?php echo SearchEngine::NEWS ?>" class="onglet_recherches <?php echo ($moteur == SearchEngine::NEWS ? "onglet_selected" : "") ?>">
						<div id="left<?php echo SearchEngine::NEWS ?>" class="onglet_left <?php echo ($moteur == SearchEngine::NEWS ? "onglet_selected" : "") ?>"></div>
						<div id="middle<?php echo SearchEngine::NEWS ?>" class="onglet_middle <?php echo ($moteur == SearchEngine::NEWS ? "onglet_selected" : "") ?>">News</div>
						<div id="right<?php echo SearchEngine::NEWS ?>" class="onglet_right <?php echo ($moteur == SearchEngine::NEWS ? "onglet_selected" : "") ?>"></div>
					</div>
				</a>
				<a href="javascript:" onclick="changeMoteur(<?php echo SearchEngine::IMG ?>);">
					<div id="recherches<?php echo SearchEngine::IMG ?>" class="onglet_recherches <?php echo ($moteur == SearchEngine::IMG ? "onglet_selected" : "") ?>">
						<div id="left<?php echo SearchEngine::IMG ?>" class="onglet_left <?php echo ($moteur == SearchEngine::IMG ? "onglet_selected" : "") ?>"></div>
						<div id="middle<?php echo SearchEngine::IMG ?>" class="onglet_middle <?php echo ($moteur == SearchEngine::IMG ? "onglet_selected" : "") ?>">Images</div>
						<div id="right<?php echo SearchEngine::IMG ?>" class="onglet_right <?php echo ($moteur == SearchEngine::IMG ? "onglet_selected" : "") ?>"></div>
					</div>
				</a>
				<?php if(false) : ?>
				<a href="javascript:" onclick="changeMoteur(<?php echo SearchEngine::SHOP ?>);">
					<div id="recherches<?php echo SearchEngine::SHOP ?>" class="onglet_recherches <?php echo ($moteur == SearchEngine::SHOP ? "onglet_selected" : "") ?>">
						<div id="left<?php echo SearchEngine::SHOP ?>" class="onglet_left <?php echo ($moteur == SearchEngine::SHOP ? "onglet_selected" : "") ?>"></div>
						<div id="middle<?php echo SearchEngine::SHOP ?>" class="onglet_middle <?php echo ($moteur == SearchEngine::SHOP ? "onglet_selected" : "") ?>">Shopping</div>
						<div id="right<?php echo SearchEngine::SHOP ?>" class="onglet_right <?php echo ($moteur == SearchEngine::SHOP ? "onglet_selected" : "") ?>"></div>
					</div>
				</a>
				<?php endif; ?>
			</div>
			<div class="avancees"><a href="#">Recherches Avancées</a></div>

		</div>
	</form>
	
	<?php if ($textSearch == ""): ?>
	<div id="bodyContentHomme">
	
		<?php if (!$sf_user->isAuthenticated()): ?>
		<div class="module acteur">
			<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
			<p class="title">Devenez acteur de la reforestation</p>
			<div class="content">
				<p>Créez votre compte et collectez GRATUITEMENT des arbres au fur et à mesure de vos recherches</p>
				<p>Vous choisissez ensuite vous même où les planter sur la Planète parmi les programmes de reforestation que nous soutenons</p>
				<p class="center">
					<a href="<?php echo url_for("user/inscription"); ?>" class="button green"><strong>Créer un compte</strong></a>
				</p>
				<p class="center">
					<a href="#" class="button green">Définir Up2green comme moteur<br/>de recherche par defaut</a>
				</p>
			</div>
			<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
		</div>
		<?php else: ?>
		<div class="module acteur">
			<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
			<p class="title">Plantez vos arbres</p>
			<div class="content">
				<p>Vous pouvez dès à présent accéder à la plateforme de reforestation et planter vos arbres si vous en avez collectés suffisement</p>
				<p class="center">
					<a href="<?php echo url_for("plantation/index"); ?>" class="button green">Accéder à la plateforme de reforestation</a>
				</p>
			</div>
			<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
		</div>
		<?php endif; ?>
		
		<div class="module statistiques">
			<img class="title middle right" src="/images/module/green/icon/stats.png" alt="" />
			<p class="title">Statistiques</p>
			<div class="content">
				<p><img class="img_map" src="/images/moteur/stats_maps_200x70.png" /></p>
				<p class="center tooltiped" tooltip="Les forêts sont reconnues pour être de véritables puits de carbone.<br /> A titre indicatif, d’après l’ONU, pendant sa croissance un arbre capte en moyenne 12 kgs de CO2 par an et rejette l’oxygène nécessaire à la respiration dune famille de 4 personnes" style="padding:10px 0;">
					Arbres plantés : <strong style="color:#015F00;"><?php echo $totalTrees; ?></strong> <br/>
					soit plus de <strong style="color:#015F00;"><?php echo number_format($totalTrees*sfConfig::get('app_conversion_tree_co2'), 2, ',', ' '); ?></strong> tonnes<br/>
					de CO<sub>2</sub> compensés
				</p>
			</div>
			<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
		</div>
		
		<?php if (!$sf_user->isAuthenticated()): ?>
		<div class="module purple partenaires">
			<img class="title middle right" src="/images/module/purple/icon/icon-partenaires.png" alt="" />
			<p class="title">Partenaires</p>
			<div class="content">
				<p>Entreprises et collectivités, devenez acteur de la reforestation en impliquant vos administrés, client et colaborateur...</p>
				<div class="lien_partenaires righter">
					<a href="<?php echo sfConfig::get('app_url_blog'); ?>">plus d'informations ici</a>
				</div>
			</div>
			<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
		</div>
		<?php endif; ?>
	
	</div>
	<?php else: ?>
	<div id="bodyContent">

		<?php
		if (in_array($moteur, array(SearchEngine::WEB, SearchEngine::IMG, SearchEngine::NEWS))) {
			echo '
				<div id="ads_search">
					<p class="warning" style="width:75%;margin:0 auto;">
						L\'obtention des arbres au fil de vos recherches, grâce aux liens publicitaires, sera active dans les prochains jours.
					</p>
				</div>
			';
		}
		
		if ($moteur == SearchEngine::WEB) {
			echo '<div id="searchResults" class="web-result">';
			foreach ($results as $result) { echo include_partial("web", array('result' => $result)); }
			echo '</div>';
			echo '<div class="clear"></div>';
		}
		elseif ($moteur == SearchEngine::IMG) {
			echo '<div id="searchResults" class="img-result">';
			foreach ($results as $result) { echo include_partial("img", array("result" => $result)); }
			echo '</div>';
			echo '<div class="clear"></div>';
		}
		elseif ($moteur == SearchEngine::NEWS) {
			echo '<div id="searchResults" class="news-result">';
			foreach ($results as $result) { echo include_partial("new", array("result" => $result)); }
			echo '</div>';
			echo '<div class="clear"></div>';
		}
		elseif ($moteur == SearchEngine::SHOP) {
			echo '<div id="searchResults" class="shop-result">';
			foreach ($results as $result) { echo include_partial("shop", array("result" => $result)); }
			echo '</div>';
			echo '<div class="clear"></div>';
		}
		?>
		<div class="more-result">
			<span id="searchMore" class="button white big">Plus de Résultats</span>
		</div>
	</div>
	<?php endif ; ?>
</div>
