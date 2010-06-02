<div class="corps">
    <div class="menu_left">
        <ul class="liens_achat">
            <li><a href="#">lien1</a></li>
            <li><a href="#">lien2</a></li>
            <li><a href="#">lien3</a></li>
            <li><a href="#">lien4</a></li>
            <li><a href="#">lien5</a></li>
            <li><a href="#">lien6</a></li>
            <li><a href="#">lien7</a></li>
            <li><a href="#">lien8</a></li>
            <li><a href="#">lien9</a></li>
            <li><a href="#">lien10</a></li>
        </ul>
    </div>
    <div class="centre">
        <form name="recherche" action="" method="post">
            <div class="search">
                <input type="hidden" name="hidden_text_search" value="<?php echo $textSearch ?>" />
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
                <div class="head_acteur"><div class="titre_acteur">Devenez acteur de la reforestation</div></div>
                <div class="corps_acteur">
                    <div class="contenus_acteur">
                        <p>Créez votre compte et collectez GRATUITEMENT des arbres au fur et à mesure de vos recherches</p>
                        <p>
                            Vous choisissez ensuite vous même où les planter sur la Planète parmi les programmes de reforestation que
                            nous soutenons
                        </p>

                    </div>
                    <a href="#"><div class="btn_add_acteur"><p>Créer un compte maintenant ! </p></div></a>
                    <a href="#"><div class="btn_fav_browser"><p>Définir Up2green comme moteur<br/>de recherche par defaut</p></div></a>
                </div>
                <div class="pied_acteur"></div>
            </div>
            <div class="statistiques">
                <div class="head_stats"><div class="titre_stats">Statistiques</div></div>
                <div class="corps_stats">
                    <div class="maps"></div>
                    <div class="results_stats">Arbres plantés : <a href="#">1353</a> <br/>Plus de <a href="#">4534</a> tonnes<br/> de CO</div>
                    <a href="#"><div class="help_stats"></div></a>
                </div>
                <div class="pied_stats"></div>

                <div class="head_partenaires"><div class="titre_partenaires">Partenaires</div></div>
                <div class="corps_partenaires">
                    <div class="contenus_partenaires">
			Entreprises et collectivités, devenez acteur de la reforestation en impliquant vos administrés, client et colaborateur...</div>
                    <div class="lien_partenaires righter"><a href="#">plus d'informations ici</a></div>

                </div>
                <div class="pied_partenaires">
                </div>
            </div>
            <?php else: ?>
            <?php
            if ($moteur == SearchEngine::WEB) {
                foreach ($results as $result) { echo include_partial("web", array("result" => $result)) ; echo "<hr />" ;}
            }
            elseif ($moteur == SearchEngine::IMG) {
                foreach ($results as $result) { echo include_partial("img", array("result" => $result)) ; echo "<hr />" ;}
            }
            elseif ($moteur == SearchEngine::NEWS) {
                foreach ($results as $result) { echo include_partial("new", array("result" => $result)) ; echo "<hr />" ;}
            }
            ?>
            <?php endif ; ?>
        </div>
    </div>
</div>
