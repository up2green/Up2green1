<?php

require_once dirname(__FILE__) . '/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{

  public function setup()
  {
    $this->enablePlugins(array(
      'sfDoctrinePlugin',
      'sfOAuthPlugin',
      'sfDoctrineGuardPlugin',
      'sfFormExtraPlugin',
      'sfProtoculousPlugin',
      'sfCKEditorPlugin',
      'sfDoctrineNestedSetPlugin',
      'sfJqueryTreeDoctrineManagerPlugin',
      'ahDoctrineEasyEmbeddedRelationsPlugin',
      'sfTCPDFPlugin',
      'jmsPaymentPlugin',

      'up2gCommonPlugin',
      'up2gBlogPlugin',
    ));

    $env = sfConfig::get('sf_environment');
    if (in_array($env, array('test', 'dev')) || php_sapi_name() === 'cli') {
      $this->enablePlugins(array(
        'sfPHPUnit2Plugin',
      ));
    }
  }

}
