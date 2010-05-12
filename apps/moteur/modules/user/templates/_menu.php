<div class="left_menu_haut"></div>
<div class="menu_accueil">
    <div class="flag"></div>
    <ul class="menu">
        <?php if (! ($sf_user->isAuthenticated())):?>
        <li><a href="#">Comment ça marche ?</a></li>
        <li><a href="#">Créer mon compte</a></li>
        <li><a href="#">Définir comme page d'accueil</a></li>
        <?php else: ?>
        <li><a href="#">Mon profil</a></li>
        <li><a href="#">Ma tribu</a></li>
        <li><a href="#">Ma forêt : xxx arbres plantés et xxx arbres disponibles</a></li>
        <li><a href="#">Planter mes arbres</a></li>
        <li><a href="#">Parrainer des amis</a></li>
        <li><a href="#">Définir comme page d'accueil</a></li>
        <li><a href="<?php echo url_for1('@sf_guard_signout') ?>">Déconnexion</a></li>
        <?php endif; ?>
    </ul>

</div>
<div class="right_menu_haut"></div>
<div class="menu_connexion">
    <?php if (! ($sf_user->isAuthenticated())): ?>
        <?php include_component('sfGuardAuth', 'sideSignin'); ?>
    <?php endif; ?>
</div>

