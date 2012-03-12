<?php

/**
 * category form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class categoryForm extends BasecategoryForm
{
  protected $parentId = null;

  public function configure()
  {
    unset($this['root_id'], $this['lft'], $this['rgt'], $this['level']);
    $this->widgetSchema['parent_id'] = new sfWidgetFormDoctrineChoice(array(
        'model'     => 'category',
        'add_empty' => '~ (object is at root level)',
        'order_by'  => array('root_id, lft', ''),
        'method' => 'getIndentedName'
      ));
    $this->validatorSchema['parent_id'] = new sfValidatorDoctrineChoice(array(
        'required' => false,
        'model'    => 'category'
      ));
    $this->setDefault('parent_id', $this->object->getParentId());
    $this->widgetSchema->setLabel('parent_id', 'Dans la catégorie');
  }

  public function updateParentIdColumn($parentId)
  {
    $this->parentId = $parentId;
    // further action is handled in the save() method
  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $node = $this->object->getNode();

    if ($this->parentId != $this->object->getParentId() || !$node->isValidNode())
    {
      if (empty($this->parentId))
      {
        //save as a root
        if ($node->isValidNode())
        {
          $node->makeRoot($this->object['id']);
          $this->object->save($con);
        } else
        {
          $this->object->getTable()->getTree()->createRoot($this->object); //calls $this->object->save internally
        }
      } else
      {
        //form validation ensures an existing ID for $this->parentId
        $parent = $this->object->getTable()->find($this->parentId);
        $method = ($node->isValidNode() ? 'move' : 'insert') . 'AsFirstChildOf';
        $node->$method($parent); //calls $this->object->save internally
      }
    }
  }
}
