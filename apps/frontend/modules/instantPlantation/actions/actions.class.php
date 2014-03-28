<?php

/**
 * instantPlantation actions.
 *
 * @package    up2green
 * @subpackage instantPlantation
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class instantPlantationActions extends sfActions
{
    /**
     * @param sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->programs = array(
            'senegal' => array(
                'title' => 'Sénégal',
                'label-position' => 'right',
            ),
            'madagascar' => array(
                'title' => 'Madagascar',
                'label-position' => 'left',
            ),
            'equateur' => array(
                'title' => 'Equateur',
                'label-position' => 'right',
            ),
            'inde' => array(
                'title' => 'Inde',
                'label-position' => 'left',
            ),
            'perou' => array(
                'title' => 'Pérou',
                'label-position' => 'right',
            ),
            'colombie' => array(
                'title' => 'Colombie',
                'label-position' => 'left',
            ),
        );
    }
}
