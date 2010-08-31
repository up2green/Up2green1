<?php

class category extends Basecategory
{
  public function ReadyToChoice()
  {
        return sprintf('%s', $this->getIndentedName());
  }
  public function getParentId()
  {
    if (!$this->getNode()->isValidNode() || $this->getNode()->isRoot())
    {
      return null;
    }

    $parent = $this->getNode()->getParent();

    return $parent['id'];
  }

  public function getIndentedName()
  {
    return str_repeat('- ',$this['level']).$this['unique_name'];
  }

  public function getFullPathName()
  {
  	$output = array($this['level'] => $this['unique_name']);
  	if($this['level'] > 0)
  	{
  		for($i=0; $i<=$this['level']; $i++)
  		{
  			$q = Doctrine_Query::create()
					->from('category c')
					->where('c.root_id = ?', $this['root_id'])
					->andwhere('c.level = ?', $this['level']-$i);
				
				$tmp_categ = Doctrine_Core::getTable('category')->getOne($q);
				if(!empty($tmp_categ))
				{
					$output += array($tmp_categ['level'] => $tmp_categ['unique_name']);
				}
			}
		}
		
		ksort($output);  	
    return join(' -> ', $output);
  }
  
  public function getActiveSubs()
	{
		$q = Doctrine_Query::create()
			->from('category c')
			->where('c.root_id = ?', $this->getRootId())
			->andWhere('c.level = ?', $this->getLevel() + 1)
			->andWhere('c.lft > ?', $this->getLft());
		
		return Doctrine_Core::getTable('category')->getActive($q);
	}
  
  public function getActiveLinks($max = null)
  {
		$q = Doctrine_Query::create()
			->from('lien l')
			->where('l.category_id = ?', $this->getId());
		
		if(!is_null($max))
			$q->addlimit($max);
	 
		return Doctrine_Core::getTable('lien')->getActive($q);
	}
	
	public function getActiveArticles($max = null)
  {
		$q = Doctrine_Query::create()
			->from('article a')
			->where('a.category_id = ?', $this->getId());
		
		if(!is_null($max))
			$q->addlimit($max);
	 
		return Doctrine_Core::getTable('article')->getActive($q);
	}
	
	public function __toString()
	{
		return (string) $this->getFullPathName();
	}
}
