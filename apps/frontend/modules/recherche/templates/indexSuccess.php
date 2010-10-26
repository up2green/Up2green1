<div id="body">
	<form id="searchForm" name="recherche" action="" method="post">
		<div class="search">
			<input type="hidden" id="hidden_text_search" name="hidden_text_search" value="<?php echo $textSearch ?>" />
			<input type="hidden" id="hidden_moteur_search" name="hidden_moteur_search" value="<?php echo $moteur ?>" />
			<div class="champs"><input type="text" id="recherche_text" name="recherche_text" size="65" value="<?php echo $textSearch ?>" /></div>
			<div class="btn_search"><input type="submit" name="recherche_submit" value="Rechercher" /></div>
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
				<a href="#">
					<div class="onglet_recherches">
						<div class="onglet_left"></div>
						<div class="onglet_middle">Shopping</div>
						<div class="onglet_right"></div>
					</div>
					<div class="onglet_decoration"></div>
				</a>
			</div>
			<div class="avancees"><a href="#">Recherches Avancées</a></div>

		</div>
	</form>
	<div class="menu_centre">
		<?php if ($textSearch == ""): ?>
		<div class="acteur">
			<div class="module">
		<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
		<p class="title">Devenez acteur de la reforestation</p>
		<div class="content">
			<p>Créez votre compte et collectez GRATUITEMENT des arbres au fur et à mesure de vos recherches</p>
			<p>Vous choisissez ensuite vous même où les planter sur la Planète parmi les programmes de reforestation que nous soutenons</p>
			<p class="center">
				<a href="#" class="button green">Créer un compte</a>
			</p>
			<p class="center">
				<a href="#" class="button green">Définir Up2green comme moteur<br/>de recherche par defaut</a>
			</p>
		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>
		</div>
		<div class="statistiques">
			<div class="module">
		<img class="title middle right" src="/images/module/green/icon/stats.png" alt="" />
		<p class="title">Statistiques</p>
		<div class="content">
		<p><img class="img_map" src="/images/moteur/stats_maps_200x70.png"</p>
		<p class="center">Arbres plantés : <a href="#">1353</a> <br/>Plus de <a href="#">4534</a> tonnes<br/> de CO</p>
		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>

			<div class="head_partenaires"><div class="titre_partenaires">Partenaires</div></div>
			<div class="corps_partenaires">
				<div class="contenus_partenaires">
		Entreprises et collectivités, devenez acteur de la reforestation en impliquant vos administrés, client et colaborateur...
		</div>
				<div class="lien_partenaires righter">
		<a href="#">plus d'informations ici</a>
		</div>

			</div>
			<div class="pied_partenaires">
			</div>
	</div>
	</div>
		<?php else: ?>
		<?php
		if ($moteur == SearchEngine::WEB) {
			foreach ($results as $result) { echo include_partial("web", array("result" => $result)); echo "<hr />" ;}
		}
		elseif ($moteur == SearchEngine::IMG) {
			echo '<div id="searchResults" class="img-result">';
			foreach ($results as $result) { echo include_partial("img", array("result" => $result));}
			echo '</div>';
			echo '<div class="clear"></div>';
		}
		elseif ($moteur == SearchEngine::NEWS) {
			foreach ($results as $result) { echo include_partial("new", array("result" => $result)) ; echo "<hr />" ;}
		}
		?>
		<div class="more-result">
			<span id="searchMore" class="button white big">Plus de Résultats</span>
		</div>
		<?php endif ; ?>
	</div>
</div>
