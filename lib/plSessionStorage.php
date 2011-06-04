<?php
class plSessionStorage extends sfPDOSessionStorage
{
 /**
  * Writes session data.
  *
  * @param  string $id    A session ID
  * @param  string $data  A serialized chunk of session data
  *
  * @return bool true, if the session was written, otherwise an exception is thrown
  *
  * @throws DatabaseException If the session data cannot be written
  */
  public function sessionWrite($id, $data)
  {
    // get table/column
    $db_table    = $this->options['db_table'];
    $db_data_col = $this->options['db_data_col'];
    $db_id_col   = $this->options['db_id_col'];
    $db_time_col = $this->options['db_time_col'];
 
    $db_auth_col       = 'is_authenticated';
    $db_request_col    = 'last_request_time';
    $db_user_col       = 'user_id';
    $db_app_col        = 'app';
    $db_module_col     = 'module';
    $db_action_col     = 'action';
    $db_ajax_col       = 'is_ajax';
    $db_ip_col         = 'ip';
    $db_culture_col    = 'culture';
    $db_user_agent_col = 'user_agent';
 
    $is_authenticated  = (bool)   $this->read(sfBasicSecurityUser::AUTH_NAMESPACE);
    $last_request_time = (int)    $this->read(sfBasicSecurityUser::LAST_REQUEST_NAMESPACE);
    $user_id           = (int)    $this->getUtilisateurIdFromSessData();
    $app               = (string) $this->getCurrentApp();
    $module            = (string) $this->getCurrentModuleName();
    $action            = (string) $this->getCurrentActionName();
    $is_ajax           = (bool)   $this->isAjax();
    $ip                = (string) $_SERVER['REMOTE_ADDR'];
    $culture           = (string) $this->read(sfBasicSecurityUser::CULTURE_NAMESPACE);
    $user_agent        = (string) $_SERVER['HTTP_USER_AGENT'];
 
    $sql = 'UPDATE ' . $db_table
         . ' SET '   . $db_data_col       . ' = ?, '
         . $db_time_col       . ' = ' . time() . ', '
         . $db_auth_col       . ' = ?, '
         . $db_request_col    . ' = ?, '
         . $db_user_col       . ' = ?, '
         . $db_app_col        . ' = ?, '
         . $db_module_col     . ' = ?, '
         . $db_action_col     . ' = ?, '
         . $db_ajax_col       . ' = ?, '
         . $db_ip_col         . ' = ?, '
         . $db_culture_col    . ' = ?, '
         . $db_user_agent_col . ' = ? '
         . 'WHERE '  . $db_id_col         . ' = ?';
 
    try
    {
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(1,  $data,              PDO::PARAM_STR);
      $stmt->bindParam(2,  $is_authenticated,  PDO::PARAM_BOOL);
      $stmt->bindParam(3,  $last_request_time, PDO::PARAM_INT);
      $stmt->bindParam(4,  $user_id,           PDO::PARAM_INT);
      $stmt->bindParam(5,  $app,               PDO::PARAM_STR);
      $stmt->bindParam(6,  $module,            PDO::PARAM_STR);
      $stmt->bindParam(7,  $action,            PDO::PARAM_STR);
      $stmt->bindParam(8,  $is_ajax,           PDO::PARAM_BOOL);
      $stmt->bindParam(9,  $ip,                PDO::PARAM_STR);
      $stmt->bindParam(10, $culture,           PDO::PARAM_STR);
      $stmt->bindParam(11, $user_agent,        PDO::PARAM_STR);
      $stmt->bindParam(12, $id,                PDO::PARAM_STR);
      $stmt->execute();
    }
    catch (PDOException $e)
    {
      throw new sfDatabaseException(sprintf('PDOException was thrown when trying to manipulate session data. Message: %s', $e->getMessage()));
    }
 
    return true;
  }
 
  public function getUtilisateurIdFromSessData()
  {
    $attributes = $this->read(sfBasicSecurityUser::ATTRIBUTE_NAMESPACE);
    if (is_array($attributes) && isset($attributes['Utilisateur']) && isset($attributes['Utilisateur']['utilisateur_id']))
    {
      return $attributes['Utilisateur']['utilisateur_id'];
    }
 
    return 0;
  }
 
  public function getCurrentApp()
  {
    if (sfContext::hasInstance())
    {
      return sfContext::getInstance()->getConfiguration()->getApplication();
    }
 
    return '';
  }
 
  public function getCurrentModuleName()
  {
    if (sfContext::hasInstance())
    {
      return sfContext::getInstance()->getModuleName();
    }
 
    return '';
  }
 
  public function getCurrentActionName()
  {
    if (sfContext::hasInstance())
    {
      return sfContext::getInstance()->getActionName();
    }
 
    return '';
  }
 
  public function isAjax()
  {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'XMLHttpRequest' ==  $_SERVER['HTTP_X_REQUESTED_WITH'])
    {
      return true;
    }
 
    return false;
  }
 
  public function regenerate($destroy = false)
  {
    if (self::$sessionIdRegenerated)
    {
      return;
    }
 
    $currentId = session_id();
    self::$sessionIdRegenerated = true;
 
    return $this->sessionWrite($currentId, $this->sessionRead($currentId));
  }
	
	public static function getNbVisiteursConnectes()
{
  $query = SessionTable::getInstance()->createQuery('s')
           ->where('s.is_authenticated = ?', false)
           ->andWhere('s.last_request_time > ?',strtotime("-20 minutes"));
 
  return $query->count();
}

public function getEtatDeConnexion()
{
  if (null == $this->_session)
  {
    $this->_session = SessionTable::getDerniereSessionPourUnUtilisateurId($this->getId());
  }
 
  if ($this->_session instanceof Session)
  {
    if ($this->_session->getLastRequestTime() < (time() - (1200)))
    {
      return self::UTILISATEUR_INACTIF;
    }
 
    return self::UTILISATEUR_CONNECTE;
  }
 
  return self::UTILISATEUR_DECONNECTE;
}

public static function getDerniereSessionPourUnUtilisateurId($utilisateur_id)
{
  return SessionTable::getInstance()->createQuery('s')
         ->where('s.user_id = ?', $utilisateur_id)
         ->orderBy('s.last_request_time DESC')
         ->fetchOne();
}

}