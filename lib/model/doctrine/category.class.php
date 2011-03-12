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

	$parent = $this;
	$startLevel = $parent['level'];

	while(
		$parent->getNode()->isValidNode() &&
		!$parent->getNode()->isRoot() &&
		$parent['level'] > 0 &&
		$parent['level'] > $startLevel - 2 ){

		$parent = $parent->getNode()->getParent();
		$output += array($parent['level'] => $parent['unique_name']);
	}

	if($parent['level'] > 0) {
		$output += array(($parent['level']-1) => '...');
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
			->andWhere('c.lft > ?', $this->getLft())
			->andWhere('c.rgt < ?', $this->getRgt());
		
		return Doctrine_Core::getTable('category')->getActive($q);
	}
  
  public function getActiveLinks($max = null)
  {
		$q = Doctrine_Query::create()
			->from('lien l')
			->where('l.category_id = ?', $this->getId())
			->orderBy('l.rank ASC');
		
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
