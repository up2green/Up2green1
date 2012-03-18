<?php

class Version73 extends Doctrine_Migration_Base
{
  protected static $mainMenuId = 2;
  protected static $associationMenuId = 5;
  
  public function up()
  {
    $this->clean();

    // Update the rank of association category
    Doctrine_Query::create()
      ->update('category c')
      ->where('c.id = ?', self::$associationMenuId)
      ->set('rank', 5)
      ->execute();

    // Create the new categories
    $partenaireCategoryId = $this->createCategory('partenaires', 3);
    $thematiqueCategoryId = $this->createCategory('thematiques', 4);
    $programmeCategoryId  = $this->createCategory('programmes', 2);

    // Create the links
    $this->createLink('Accueil', 'Home', '/', 0, self::$mainMenuId);
    $this->createLink('Articles', 'Articles', '/blog/article', 1, self::$mainMenuId);
    $this->createLink('Programmes', 'Programmes', '/blog/programme', 0, $programmeCategoryId);

    $this->createLink('Nos partenaires', 'Our partners', '#', 0, $partenaireCategoryId);
    $this->createLink('Les organismes planteurs', 'Agencies planters', '/blog/organisme', 1, $partenaireCategoryId);
    $this->createLink('Partenariats entreprise', 'Business partnerships', '/blog/partenaire', 2, $partenaireCategoryId);

    $this->createLink('Thematiques', 'Thematics', '#', 0, $thematiqueCategoryId);
    $this->createLink('La biodiversité', 'Biodiversity', '/blog/article/11', 1, $thematiqueCategoryId);
    $this->createLink('Communauté', 'Community', '/blog/article/22', 2, $thematiqueCategoryId);
    $this->createLink('Climat', 'Climate', '/blog/article/23', 3, $thematiqueCategoryId);

    $this->createLink('L\'association ', 'The association', '#', 0, self::$associationMenuId);
    $this->createLink('Présentation', 'Presentation', '/blog/article/16', 1, self::$associationMenuId);
    $this->createLink('L\'équipe', 'The team', '/blog/article/3', 2, self::$associationMenuId);
    $this->createLink('Contactez nous', 'Contact us', 'mailto:contact@up2green.com 	', 3, self::$associationMenuId);
  }

  public function down()
  {
    $this->clean();

    // Update the rank of association category
    Doctrine_Query::create()
      ->update('category c')
      ->where('c.id = ?', self::$mainMenuId)
      ->set('rank', 0)
      ->execute();
  }
  
  protected function clean()
  {
    // Get the categories ids
    $categories = array_keys(Doctrine_Query::create()
      ->select('c.id')
      ->from('category c INDEXBY c.id')
      ->whereIn('c.unique_name', array('partenaires', 'thematiques', 'main-menu', 'association'))
      ->fetchArray());

    Doctrine_Query::create()
      ->delete('lien l')
      ->whereIn('l.category_id', $categories)
      ->execute();

    Doctrine_Query::create()
      ->delete('category c')
      ->whereIn('c.unique_name', array('partenaires', 'thematiques'))
      ->execute();
  }
  
  protected function createCategory($name, $rank)
  {
    $parent = Doctrine::getTable('category')->find(self::$mainMenuId);

    $category = new category();
    $category->getNode()->insertAsLastChildOf($parent);

    $category->setUniqueName($name);
    $category->setIsActive(true);
    $category->setRank($rank);
    $category->save();
    
    return $category->getId();
  }

  protected function createLink($fr, $en, $src, $rank, $categoryId)
  {
    $lien = new lien();
    $lien->setSrc($src);
    $lien->setRank($rank);
    $lien->setCategoryId($categoryId);
    $lien->setIsActive(true);
    
    $lien->setDefaultCulture('fr');
    $lien->setTitle($fr);
    $lien->save();
    
    $lien->setDefaultCulture('en');
    $lien->setTitle($en);
    $lien->save();
  }
}
