<?php

class CBase {

    public $contentTagName = '';

    function __construct($appli) {

        $this->appli = $appli;

        $componentName = strtolower(substr(get_class($this), 1));
		
        if($this->appli->websitePath != '')
            $requirePath = $this->appli->websitePath . '/components/' . $componentName . '/';
        else
            $requirePath = '';

        if (file_exists($requirePath . 'm_' . $componentName . '.php'))
		{
		require_once($requirePath . 'm_' . $componentName . '.php');
		}
		else
		{
		$globalRequirePath = $this->appli->pathWebApp. 'components/' . $componentName . '/';
		//die($globalRequirePath . 'm_' . $componentName . '.php');
		if (file_exists($globalRequirePath . 'm_' . $componentName . '.php'))
		require_once($globalRequirePath . 'm_' . $componentName . '.php');
		}
        
		if (file_exists($requirePath . 'v_' . $componentName . '.php'))
		require_once($requirePath . 'v_' . $componentName . '.php');
		else
		{
		$globalRequirePath = $this->appli->pathWebApp. 'components/' . $componentName . '/';
		//die($globalRequirePath . 'm_' . $componentName . '.php');
		if (file_exists($globalRequirePath . 'v_' . $componentName . '.php'))
		require_once($globalRequirePath . 'v_' . $componentName . '.php');
		
		}
        
        $modelName = 'M' . substr(get_class($this), 1);
        $viewName = 'V' . substr(get_class($this), 1);

        $this->model = new $modelName($appli);
        $this->view = new $viewName($appli, $this->model);
		
        $filename = $this->appli->websitePath.'/configuration/'. strtolower(substr(get_class($this),1)) . '.conf.php';
        if (file_exists($filename))
            require_once($filename);
		
        $lngFilename = $this->appli->websitePath . '/languages/' . $this->appli->language . '/' .strtolower(substr(get_class($this),1)) .'.php';
		
        if (file_exists($lngFilename))
            require_once($lngFilename);
    }
    function initUrlRequest($paramsList,$initValue='',&$arTarget)
	{
	
		if (is_array($paramsList))
		{

	foreach ($paramsList as $param)
		{
			if (!isset($arTarget[$param]))
			$arTarget[$param]=$initValue;
			
		}
			
		}
	}
    function __destruct() {
        
    }

}

?>