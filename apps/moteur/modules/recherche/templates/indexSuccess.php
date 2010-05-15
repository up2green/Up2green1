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
                <input type="hidden" id="hidden_text_search" value="<?php echo $textRecherche ?>" />
                <input type="hidden" id="hidden_moteur_search" value="<?php echo $moteur ?>" />
                <div class="champs"><input type="text" name="recherche_submit" size="65" value="<?php echo $textRecherche ?>" /></div>
                <div class="btn_search"><input type="submit" name="recherche_submit" value="Rechercher" /></div>
            </div>
            <div class="more_search">
                <div class="filtres">
                    <input type="radio" name="recherche_moteur" value="<?php echo SearchEngine::WEB ?>" <?php echo ($moteur == SearchEngine::WEB ? "SELECTED" : "") ?> />Web
                    <input type="radio" name="recherche_moteur" value="<?php echo SearchEngine::IMG ?>" <?php echo ($moteur == SearchEngine::IMG ? "SELECTED" : "") ?> />Images
                    <input type="radio" name="recherche_moteur" value="<?php echo SearchEngine::NEWS ?>" <?php echo ($moteur == SearchEngine::NEWS ? "SELECTED" : "") ?> />Actualités
                </div>
                <div class="avancees"><a href="#">Recherches Avancées</a></div>
            </div>
        </form>
        <div class="menu_centre">
            <div class="acteur">
                <div class="head_acteur">devenez acteur de la reforestation</div>
                <div class="corps_acteur">
                    <div class="contenus_acteur">
														créez un compte et plantez vous même vos arbres sur la planète dans les programmes de reforestations partenaires !<br/>
														C’est simple et gratuit, vous pourrez gérer vos coupons arbres, participer en profitants de nos offres ou bien offrir vos coupons.

                    </div>
                    <a href="#"><div class="btn_add_acteur"></div></a>
                </div>
                <div class="pied_acteur"></div>
            </div>
            <div class="statistiques">
                <div class="head_stats">Statistiques</div>
                <div class="corps_stats">
                    <div class="maps"></div>
                    <div class="results_stats">Arbres plantés : 1353
                        <br/>451 011 534 g. de CO</div>
                    <a href="#"><div class="btn_entreprise"></div></a>
                    <div class="link_add_part">Contactez-nous
                        pour devenir partenaire</div>
                </div>
                <div class="pied_stats"></div>
            </div>
        </div>
    </div>
</div>
