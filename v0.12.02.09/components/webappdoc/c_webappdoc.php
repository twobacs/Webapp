<?php


class CWebappdoc extends CBase
{
function  __construct($appli) {

        parent::__construct($appli);
		//die('jm a une tres petite');
		if ($appli->action=='')
		$appli->action='showIndex';
    }
   function showIndex()
   {
   $this->view->showIndex();
   }
   function showList()
   {
    $this->model->loadList($this->appli);
    $this->view->showList();
   }
   function showDetail()
   {
   $target= $this->appli->getUrlVar('target');
   if ($target=='')
   $target='main';
   $this->view->showDetail($target);
   
   }
   function getImg()
   {
    
	$file=$this->appli->getUrlVar('img');
	$filename=$this->appli->pathWebApp.'docs/images/'.$file;
	if (file_exists($filename) )
	{
    
    header('Content-Length: ' . filesize($filename));
	header('Content-Type: image/jpeg');
	readfile($filename);
	}
    exit;
   }

}


?>