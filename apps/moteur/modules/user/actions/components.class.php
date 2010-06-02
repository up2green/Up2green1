<?php
class userComponents extends sfComponents {
    public function executeMenu($request) {
        
    }
    public function executeSideSignin($request) {
        $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
        $this->signinForm = new $class();
    }
}