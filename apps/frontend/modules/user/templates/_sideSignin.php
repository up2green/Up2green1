<form id="signinForm" action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="clearfix">
    <ul class="menu">
        <li><a tabindex="4" href="<?php echo url_for('@user_forgot_password') ?>"><img src="/images/btn_pass_forgive_20x20.png" title="Mot de passe perdu" /></a></li>
        <li><input class="button small white" tabindex="3" type="submit" name="btnValider" value="<?php echo __("Envoyer") ?>" /></li>
        <li><input tabindex="2" type="password" id="signin_password" name="signin[password]" size="15" value="<?php echo __("Mot de passe") ?>" title="<?php echo __("Mot de passe") ?>" /></li>
        <li><input tabindex="1" type="text" name="signin[username]" id="signin_username" size="15" value="<?php echo __("Nom d'utilisateur") ?>" title="<?php echo __("Nom d'utilisateur") ?>" /></li>
    </ul>
    <?php echo $signinForm->renderHiddenFields(); ?>
    <input type="hidden" name="signin[remember]" id="signin_remember" value="on" />
</form>
