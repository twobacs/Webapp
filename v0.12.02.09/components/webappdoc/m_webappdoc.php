<?php


include_once($this->appli->pathWebApp. '/components/base/m_base.php');
class MWebappdoc extends MBase {

    function __construct($appli) {
        parent::__construct($appli);
		
    }

    function loadList() {
     
    $this->arAttribs= get_class_vars(get_class($this->appli));	 
	ksort($this->arAttribs);
	$this->arMethods=get_class_methods(get_class($this->appli));	
	sort($this->arMethods);
    }

}
?>