<div class="corps">
    <div class="centre">
        <h2>Nouveau mot de passe</h2>
        <?php if (isset($pwd)): ?>
        Le nouveau mot de passe a été envoyé par mail à l'adresse renseignée sur le profil.
        <?php else: ?>
        <form method="post" action="" name="pwd">
            <input type="text" name="username" value="Nom d'utilisateur" onfocus="this.value='';"/><br />
            <input type="submit" name="forgotPassword" value="Envoyer" />
        </form>
        <p>
            <i>En cliquant sur "Envoyer", un nouveau mot de passe sera généré et envoyé à l'adresse mail renseignée sur le profil. <br />
                Une fois ce mot de passe changé, l'ancien ne sera plus valable.</i>
        </p>
        <?php endif; ?>
    </div>
</div>