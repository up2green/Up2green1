<?php $moteur = (int)$moteur; ?>

<div id="body">

	<form id="searchForm" name="recherche" action="" method="post">
		<div class="search">
			<input type="hidden" id="hidden_text_search" name="hidden_text_search" value="<?php echo $textSearch ?>" />
			<input type="hidden" id="hidden_moteur_search" name="hidden_moteur_search" value="<?php echo $moteur ?>" />
			<input type="text" id="recherche_text" name="recherche_text" size="60" value="<?php echo $textSearch ?>" />
			<input type="submit" id="recherche_submit" name="recherche_submit" value="Rechercher" class="button white small" />
		</div>

		<div class="filtres">
			<span searchMode="<?php echo SearchEngine::WEB ?>" class="button top-not-rounded <?php echo ($moteur == SearchEngine::WEB ? 'green active' : 'gray'); ?> medium first">Web</span>
			<span searchMode="<?php echo SearchEngine::IMG ?>" class="button top-not-rounded <?php echo ($moteur == SearchEngine::IMG ? 'green active' : 'gray'); ?> medium">Images</span>
			<span searchMode="<?php echo SearchEngine::NEWS ?>" class="button top-not-rounded <?php echo ($moteur == SearchEngine::NEWS ? 'green active' : 'gray'); ?> medium">News</span>
			<span searchMode="<?php echo SearchEngine::SHOP ?>" class="button top-not-rounded <?php echo ($moteur == SearchEngine::SHOP ? 'orange active' : 'orange-gray hover'); ?> medium">Achats</span>

			<a class="more-search" href="#">Recherches Avancées</a>
		</div>
	</form>
	
	<?php 
	if ($textSearch == "") {
		include_partial('home', array(
			'totalTrees' => $totalTrees
		));
	}
	elseif (in_array($moteur, array(SearchEngine::WEB, SearchEngine::IMG, SearchEngine::NEWS, SearchEngine::SHOP))) {

		// warning

		echo '
			<div id="ads_search">
				<ul class="content-list warning" style="width:75%;margin:0 auto 20px;">
					<li>L\'obtention des arbres au fil de vos recherches, grâce aux liens publicitaires, sera active dans les prochains jours.</li>
					<li>L\'obtention des arbres grâce aux sites marchand (liens Achats) est soumis à un délai d\'une à 3 semaines.</li>
				</p>
			</div>
		';

		if (in_array($moteur, array(SearchEngine::WEB, SearchEngine::IMG, SearchEngine::NEWS))) {
			if(!empty($singleShopResult)) {
				echo '<div class="shop-result">';
				include_partial('shop', array('result' => $singleShopResult));
				echo '</div>';
			}
		}

		// results
		$partial = ($moteur === SearchEngine::WEB) ? "web" :
			(($moteur === SearchEngine::IMG) ? "img" :
			(($moteur === SearchEngine::NEWS) ? "news" :
			(($moteur === SearchEngine::SHOP) ? "shop" : "default")));

		echo '<div id="searchResults" class="'.$partial.'-result">';
		
		if(sizeof($results) === 0) {
			echo '
				<p style="text-align: center; font-style: italic; font-weight: bold;">
					Aucun résultat ne correspond à votre recherche.
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
					<span id="searchMore" class="button white big">Plus de Résultats</span>
				</div>
			';
		}
	}
	?>
</div>
