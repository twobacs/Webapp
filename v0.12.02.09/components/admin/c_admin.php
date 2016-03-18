<?php
class CAdmin extends CBase
{

    function  __construct($appli) {
        parent::__construct($appli);
    
	}

   function Display()
   {
    die('rien a fout la');
   }
   function deployComponent()
   {
   //creer un dossier local au site du nom ???? 
   
   echo $this->appli->getUrlVar('componentname');
   echo $this->appli->getUrlVar('actionname');
   $this->model->createComponent($this->appli->websitePath,$this->appli->getUrlVar('componentname'));
   
   }


}


?>