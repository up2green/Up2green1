<form id="signinForm" action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="clearfix">
    <div class="fav_account">
        <input type="checkbox" name="signin[remember]" id="signin_remember" />
        <label for="signin_remember">Se souvenir de moi</label>
    </div>

    <div class="btn_connexion">
        <?php echo $signinForm->renderHiddenFields(); ?>
        <input type="submit" name="btnValider" value="validez" />
    </div>

    <div class="password">
        <input type="text" id="signin_password" name="signin[password]" size="15" value="votre pass" onfocus="this.value='';"/>
    </div>

    <div class="user_name">
        <input type="text" name="signin[username]" id="signin_username" size="15" value="votre login" onfocus="this.value='';" />
    </div>
</form>
