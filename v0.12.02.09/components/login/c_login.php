<?php
include_once('c_base.php');

class CLogin extends CBase
{

    function  __construct($appli) {
        parent::__construct($appli);
         
    }



    function defaultAction()
    {
 $this->view->showLogin();
      
        }
   function login()
   {
      
      if (isset($this->appli->urlVars['user']))
      $login = $this->appli->urlVars['user'];
	else $login='';
      if (isset($this->appli->urlVars['password']))
      $pass = $this->appli->urlVars['password'];
	else $login='';

      if($login == '' || $pass == '')
         $this->view->showLogin();
      else
      {
         if(!$this->model->login($login, $pass) === false)
         {
            $_SESSION['usrId'] = $this->appli->user->getId();
            $this->appli->setLogged(true);
            $this->view->login(10);
         }
         else
         {
            $this->view->login(0);
         }
      }
   }
   function disconnect()
   {
    $this->appli->user->loadVisitorData();
    $this->appli->setLogged(false);
    $_SESSION['usr_pkey']=-1;

   }


}


?>
