<?php


class newsletterTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('newsletter');
    }

	public function getBySlug($slug) {
		$q = $this->createQuery('n')
			->leftJoin('n.Translation t')
			->andWhere('t.slug = ?', $slug);

		return $q->fetchOne();
	}
}