<div class="menu_haut">
    <div class="left_menu_haut"></div>
    <div class="middle_menu_haut">


        <?php if (! ($sf_user->isAuthenticated())):?>
        <div class="menu_accueil">
            <div class="flag">

            </div>
            <ul class="menu">
                <li><a href="#">Comment ça marche ?</a></li>
                <li><a href="#">Définir comme page d'accueil</a></li>
                <li><a href="<?php echo url_for("user/inscription") ?>">Créer mon compte</a></li>
            </ul>
        </div>
        <div class="menu_connexion">
                <?php echo include_component('user', 'sideSignin'); ?>
        </div>
        <?php else: ?>
        <div class="menu_accueil">
            <div class="flag"></div>
            <ul class="menu">
                <li><a href="#">Comment ça marche ?</a></li>
                <li><a href="#">Définir comme page d'accueil</a></li>
            </ul>
        </div>
        <div class="menu_connexion">
            <ul class="menu_connexion_co">
                <li><a href="#">Planter mes arbres</a></li>
                <li><a href="#">Parrainer des amis</a></li>
                <li><a href="#">Mes crédits (38 arbres)</a></li>
                <li><a href="#">Mon profil (antoinegergine@yahoo.fr)</a></li>
                <li><a href="<?php echo url_for1('@sf_guard_signout') ?>">Déconnexion</a></li>
            </ul>
        </div>
        <?php endif; ?>

    </div>
    <div class="right_menu_haut"></div>
</div>
