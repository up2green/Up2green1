<?php $moteur = (int)$moteur; ?>

<div id="body">

	<form id="searchForm" name="recherche" action="" method="post">
		<div class="search">
			<input type="hidden" id="hidden_text_search" name="hidden_text_search" value="<?php echo $textSearch ?>" />
			<input type="hidden" id="hidden_moteur_search" name="hidden_moteur_search" value="<?php echo $moteur ?>" />
			<input type="text" id="recherche_text" name="recherche_text" value="<?php echo $textSearch ?>" />
			<input type="submit" id="recherche_submit" name="recherche_submit" value="<?php echo __("Rechercher") ?>" class="button white small" />
		</div>

		<div class="filtres">
			<span searchMode="<?php echo SearchEngine::WEB ?>" class="button top-not-rounded <?php echo ($moteur == SearchEngine::WEB ? 'green active' : 'gray'); ?> medium first"><?php echo __("Web") ?></span>
			<span searchMode="<?php echo SearchEngine::IMG ?>" class="button top-not-rounded <?php echo ($moteur == SearchEngine::IMG ? 'green active' : 'gray'); ?> medium"><?php echo __("Images") ?></span>
			<span searchMode="<?php echo SearchEngine::NEWS ?>" class="button top-not-rounded <?php echo ($moteur == SearchEngine::NEWS ? 'green active' : 'gray'); ?> medium"><?php echo __("News") ?></span>
			<span searchMode="<?php echo SearchEngine::SHOP ?>" class="tooltip button top-not-rounded <?php echo ($moteur == SearchEngine::SHOP ? 'orange active' : 'orange-gray hover'); ?> medium">
				<?php echo __("Achats") ?>
				<span class="tooltip-content classic" style="width:250px">
					<?php echo __("<strong>Le moteur « Achats » revient bientôt</strong>… pour gagner des arbres à chaque achat en ligne sur l'un des 750 sites marchands affiliés à l'association (quelques temps après votre achat sur l'un des sites en question vous recevrez dans votre compte Up2green le nombre de crédits arbres fonction du montant de votre achat).") ?>
				</span>
			</span>
		</div>
	</form>
	
	<?php 
	if ($textSearch == "") {
		include_partial('home', array(
			'totalTrees' => $totalTrees
		));
	}
	elseif (in_array($moteur, array(SearchEngine::WEB, SearchEngine::IMG, SearchEngine::NEWS, SearchEngine::SHOP))) {

		echo '<div id="searchResults"';
		
		if (in_array($moteur, array(SearchEngine::WEB, SearchEngine::IMG, SearchEngine::NEWS))) {
//			if(!empty($singleShopResult)) {
//				echo '<div class="shop-result">';
//				include_partial('shop', array('result' => $singleShopResult));
//				echo '</div>';
//			}

			if(!empty($pubResults)) {
				echo '<div class="pub-result">';
				foreach ($pubResults as $result) {
					echo include_partial('pub', array('result' => $result));
				}
				echo '</div>';
			}
		}

		// results
		$partial = ($moteur === SearchEngine::WEB) ? "web" :
			(($moteur === SearchEngine::IMG) ? "img" :
			(($moteur === SearchEngine::NEWS) ? "news" :
			(($moteur === SearchEngine::SHOP) ? "shop" : "default")));

		echo '<div class="'.$partial.'-result">';
		
		if(sizeof($results) === 0) {
			echo '
				<p style="text-align: center; font-style: italic; font-weight: bold;">
					'.__("Aucun résultat ne correspond à votre recherche.").'
				</p>
			';
		}

		foreach ($results as $result) {
			echo include_partial($partial, array('result' => $result));
		}

		echo '</div>';
		echo '<div class="clear"></div>';

		// more results
		
		if(sizeof($results) >= sfConfig::get('app_base_search')) {
			echo '
				<div class="more-result">
					<span id="searchMore" class="button white big">'.__("Plus de Résultats").'</span>
				</div>
			';
		}

		echo '</div>';
	}
	?>
</div>
