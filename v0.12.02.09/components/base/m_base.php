<?php
//include_once('m_base.php');

class MBase
{
   public $dbPdo;
   public $data;
   function  __construct($appli)
   {
      $this->appli = &$appli;
      $this->dbPdo=$appli->getDbPdo();
     // print_r($this->dbmysql);


   }
   function  __destruct() {
        //echo 'destruction model base<br />';
    }

}

?>