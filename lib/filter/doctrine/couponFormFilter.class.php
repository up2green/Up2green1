<?php

/**
 * coupon filter form.
 *
 * @category Lib
 * @package  Filter
 * @author   Clément Gautier
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class couponFormFilter extends BasecouponFormFilter
{
  /**
   * @see parent 
   */
  public function configure()
  {
    $this->widgetSchema['created_at'] = new sfWidgetFormDateRange(array(
        'from_date' => new sfWidgetFormJQueryDate(array(
          'image'   => '/images/calendar.png',
        )),
        'to_date' => new sfWidgetFormJQueryDate(array(
          'image'    => '/images/calendar.png',
        )),
        'template' => 'From %from_date%<br />To %to_date%',
      ));
    $this->widgetSchema['updated_at'] = new sfWidgetFormDateRange(array(
        'from_date' => new sfWidgetFormJQueryDate(array(
          'image'   => '/images/calendar.png',
        )),
        'to_date' => new sfWidgetFormJQueryDate(array(
          'image'    => '/images/calendar.png',
        )),
        'template' => 'From %from_date%<br />To %to_date%',
      ));
    $this->widgetSchema['used_at'] = new sfWidgetFormFilterDate(array(
        'with_empty'  => true,
        'empty_label' => "Is Empty",
        'from_date' => new sfWidgetFormJQueryDate(array(
          'image'   => '/images/calendar.png',
        )),
        'to_date' => new sfWidgetFormJQueryDate(array(
          'image'    => '/images/calendar.png',
        )),
        'template' => 'From %from_date%<br />To %to_date%',
      ));

    $this->widgetSchema['user'] = new sfWidgetFormFilterInput(array(
        'template' => '%input%'
      ));

    $this->widgetSchema['partenaire'] = new sfWidgetFormFilterInput(array(
        'template' => '%input%'
      ));

    $this->validatorSchema['user'] = new sfValidatorPass(array('required' => false));
    $this->validatorSchema['partenaire'] = new sfValidatorPass(array('required' => false));
  }

  public function getFields()
  {
    return array_merge(array(
        'user'       => 'User',
        'partenaire' => 'Partenaire',
        ), parent::getFields()
    );
  }

  public function addUserColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (isset($values['text']) && !empty($values['text']))
    {
      $user = Doctrine_Core::getTable('sfGuardUser')
        ->createQuery('u')
        ->where('u.username = ?', $values['text'])
        ->fetchOne();

      if (!empty($user))
      {
        $query
          ->innerJoin($query->getRootAlias() . '.couponUser cu')
          ->andWhere('cu.user_id = ?', $user->getId())
        ;
      }
    }
  }

  public function addPartenaireColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (isset($values['text']) && !empty($values['text']))
    {
      // get the user
      $user = Doctrine_Core::getTable('sfGuardUser')
        ->createQuery('u')
        ->where('u.username = ?', $values['text'])
        ->fetchOne();

      if (!empty($user))
      {
        // get the partenaire
        $partenaire = Doctrine_Core::getTable('partenaire')
          ->createQuery('p')
          ->where('p.user_id = ?', $user->getId())
          ->fetchOne();

        if (!empty($partenaire))
        {
          $query
            ->innerJoin($query->getRootAlias() . '.Partenaire cp')
            ->andWhere('cp.partenaire_id = ?', $partenaire->getId())
          ;
        }
      }
    }
  }

}
