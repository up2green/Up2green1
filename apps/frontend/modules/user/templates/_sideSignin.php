<form id="signinForm" action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="clearfix">
    <?php echo $signinForm->renderHiddenFields(); ?>
    <ul class="menu_connexion_deco">
        <li><p>Se souvenir <br/>de moi</p></li>
        <li><input tabindex="5" type="checkbox" name="signin[remember]" id="signin_remember" />
        <label for="signin_remember"></label></li>
        <li><a tabindex="4" href="<?php echo url_for('@user_forgot_password') ?>"><img src="/images/btn_pass_forgive_20x20.png" title="Mot de passe perdu" /></a></li>
        <li><input tabindex="3" type="submit" name="btnValider" value="Connexion" /></li>
        <li><input tabindex="2" type="text" id="signin_password" name="signin[password]" size="15" value="Mot de passe" onfocus="this.value='';this.type='password';"/></li>
        <li><input tabindex="1" type="text" name="signin[username]" id="signin_username" size="15" value="Nom d'utilisateur" onfocus="this.value='';" /></li>
    </ul>
</form>