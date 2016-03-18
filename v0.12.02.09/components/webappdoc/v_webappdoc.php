<?php
include_once($this->appli->pathWebApp . '/components/base/v_base.php');
class VWebappdoc extends VBase
{

    function  __construct($appli,$model) {
        parent::__construct($appli,$model);
    }
	
	
	public function showIndex()
	{
	$page='<html><head><head>';
	$page.='<FRAMESET COLS="20%,80%">
			<FRAME SRC="?component=webappdoc&action=showList" NAME="gauche">
			<FRAME SRC="?component=webappdoc&action=showDetail" NAME="droite">
			</FRAMESET> ';
	$page.='</html>';
	
	echo $page;exit;
	}
   public function showList()
   {
    $page='<div>Properties</div>';
    $attribs='<ul>';
	foreach($this->model->arAttribs as $key=>$value)
	{
	if (file_exists($this->appli->pathWebApp.'docs/'.$key.'.html') || file_exists($this->appli->pathWebApp.'docs/'.$key.'.php'))
	$attribs.='<li><a href="?component=webappdoc&action=showDetail&target='.$key.'" target="droite">'.$key.'</a></li>';
	else
	$attribs.='<li>'.$key.'</li>';
	}
	$attribs.='</ul>';	
	
	$page.=$attribs;
	$page.='<div>Methods</div>';
	$methods='<ul>';
	foreach($this->model->arMethods as $key=>$value)
	{
	$methods.='<li>'.$value.'</li>';
	}
	$methods.='</ul>';	
	$page.= $methods;
	echo $page;
	exit;
   }
   public function showDetail($target)
   {
 
    if (file_exists($this->appli->pathWebApp.'docs/'.$target.'.html'))
	{
	echo file_get_contents($this->appli->pathWebApp.'docs/'.$target.'.html');
	exit;
	}
	else if (file_exists($this->appli->pathWebApp.'docs/'.$target.'.php'))
	{
	include($this->appli->pathWebApp.'docs/'.$target.'.php');
	exit;
	}
	else
	{
	echo 'No resources';exit;
	}
   }


}


?>