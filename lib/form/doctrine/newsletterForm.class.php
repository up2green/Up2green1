<?php

/**
 * newsletter form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterForm extends BasenewsletterForm {
    public function configure() {
        unset(
                $this['created_at'],
                $this['updated_at']
        );
        $this->widgetSchema['sent_at'] = new sfWidgetFormJQueryDate(array('image'=>'/images/calendar.png'));
        $this->embedI18n(array('en', 'fr'));
        $this->widgetSchema->setLabel('en', 'English');
        $this->widgetSchema->setLabel('fr', 'French');
        

    }
}
