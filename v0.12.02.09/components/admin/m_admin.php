<?php



class MAdmin extends MBase {

    public function __construct($appli) {
        parent::__construct($appli);
    }
function createComponent($path,$componentName)
{
//controleur
mkdir($path.'/components/'.$componentName);
$compoCodeControleur='<?php class C*compo* extends CBase
{
    function  __construct($appli) {
        parent::__construct($appli);
	}
   function *actionname*()
   {
   }
}?>';

$compoCodeControleur=str_replace('*actionname*',$this->appli->getUrlVar('actionname'),$compoCodeControleur);
$compoCodeControleur=str_replace('*compo*',ucfirst($componentName),$compoCodeControleur);

if (!file_exists($path.'/components/'.$componentName.'/c_'.$componentName.'.php'))
file_put_contents($path.'/components/'.$componentName.'/c_'.$componentName.'.php',$compoCodeControleur);
//model
mkdir($path.'/components/'.$componentName);
$compoCodeControleur='<?php class M*compo* extends MBase
{
    function  __construct($appli) {
        parent::__construct($appli);
	}
   function *actionname*()
   {
   }
}?>';

$compoCodeControleur=str_replace('*actionname*',$this->appli->getUrlVar('actionname'),$compoCodeControleur);
$compoCodeControleur=str_replace('*compo*',ucfirst($componentName),$compoCodeControleur);
if (!file_exists($path.'/components/'.$componentName.'/m_'.$componentName.'.php'))
file_put_contents($path.'/components/'.$componentName.'/m_'.$componentName.'.php',$compoCodeControleur);


//view
mkdir($path.'/components/'.$componentName);
$compoCodeControleur='<?php class V*compo* extends VBase
{
    function  __construct($appli) {
        parent::__construct($appli);
	}
   function *actionname*()
   {
   }
}?>';

$compoCodeControleur=str_replace('*actionname*',$this->appli->getUrlVar('actionname'),$compoCodeControleur);
$compoCodeControleur=str_replace('*compo*',ucfirst($componentName),$compoCodeControleur);
if (!file_exists($path.'/components/'.$componentName.'/v_'.$componentName.'.php'))
file_put_contents($path.'/components/'.$componentName.'/v_'.$componentName.'.php',$compoCodeControleur);



}

}
?>