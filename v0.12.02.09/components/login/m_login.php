<?php
include_once('m_base.php');
class MLogin extends MBase
{

   function  __construct($appli) {
        parent::__construct($appli);
    }
   function login($login, $pass)
   {
      include_once('guserclass.php');
      $user = new GUser($this->dbPdo);
      $this->appli->user=$user;
      return $user->loadUserWithPass($login, $pass);
   }

}

?>