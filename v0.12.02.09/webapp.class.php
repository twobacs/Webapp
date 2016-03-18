<?php

//version 0.11.5.4.0

class WebApp
{

	public $dbPdo;
	public $debug = true;
	public $component = '';
	public $action = '';
	public $contentData = array();
	public $head = '';
	public $arMainMenu = array();
	public $urlVars;
	public $pathWebApp;
	public $pathModel = 'model/';
	public $pathView = 'view/';
	public $localDirComponents = 'components/';
	public $globalDirComponents = 'components/';
	public $pathMenu = 'menus/';
	public $controller;
	public $logged = false;
	public $defaultComponent;
	public $defaultAction;
	public $defaultParam1Name;
	public $defaultParam1Value;
	public $jsFiles = array();
	public $jsCode;
	public $cssFiles = array();
	public $cssCode;
	public $browser;
	public $browserVersion;
	public $doCheckBrowser = false;
	public $modeResponse = 'template';
	public $tplBasePath;
	public $tplPath;
	public $tplIndex;
	public $websitePath = '';
	public $modules;
	public $translator;

	public function __construct(&$urlVars)
	{
		$this->pathWebApp = dirname(__FILE__) . '/';
		$this->websitePath= $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']);

		require_once($this->pathWebApp.'components/base/c_base.php');
		require_once($this->pathWebApp.'components/base/m_base.php');
		require_once($this->pathWebApp.'components/base/v_base.php');
		require_once('configuration/main.conf.php');
		$mainLng = 'languages/' . $this->language . '/main.php';
		if (file_exists($mainLng)) {
			require_once($mainLng);
		}

		$this->urlVars = $urlVars;
		if (isset($urlVars['component']))
		$this->component = $urlVars['component'];
		if (isset($urlVars['action']))
		$this->action = $urlVars['action'];
		if ($this->doCheckBrowser)
		$this->checkBrowser();
		if (class_exists('GUser')) {
			$this->checkUser();
		}
	}

	public function __set($name, $value)
	{
		$this->contentData[$name] = $value;
	}

	public function setJsCode($value)
	{
		$this->jsCode = $value;
	}

	public function addJsCode($value)
	{
		$this->jsCode.=$value;
	}

	public function addJsFile($filename)
	{
		$this->jsFiles[$filename] = '1';
	}
	public function getJsFiles()
	{
		$htmlJsFiles='';
		foreach ($this->jsFiles as $key => $value) 
		{
			$htmlJsFiles .= '<script type="text/javascript" src="' . $key . '"></script>';
		}
		
		return $htmlJsFiles;
	}

	public function addCssCode($value)
	{
		$this->cssCode.=$value;
	}

	public function addCssFile($filename)
	{
		$this->cssFiles[$filename] = '1';
	}
	public function getCssFiles()
	{
		$htmlCssFiles='';
		foreach ($this->cssFiles as $key => $value) 
		{
			//$htmlCssFiles .= '<script type="text/javascript" src="' . $key . '"></script>';
			$htmlCssFiles .= '<LINK REL=StyleSheet HREF="' . $key . '" TYPE="text/css" MEDIA=screen>';
		}
		
		return $htmlCssFiles;
	}


	public function addContentTop($value)
	{
		$this->contentData['ctTop'].=$value;
	}

	public function setContentTop($value)
	{
		$this->contentData['ctTop'] = $value;
	}

	public function addMainMenu($value)
	{
		$this->contentData['ctMainMenu'].=$value;
	}
	
	public function setMainMenu($value)
	{
		$this->contentData['ctMainMenu'] = $value;
	}
	
	//additions persos - début
	
	public function addCompMenu($value)
	{
		$this->contentData['ctCompMenu'].=$value;
	}
	
	public function setCompMenu($value)
	{
		$this->contentData['ctCompMenu'] = $value;
	}
	//additions persos - fin
	public function addContentBottom($value)
	{
		$this->contentData['ctBottom'].=$value;
	}

	public function setContentBottom($value)
	{
		$this->contentData['ctBottom'] = $value;
	}

	public function setContentBody($value)
	{
		$this->contentData['ctBody'] = $value;
	}

	public function addContentBody($value)
	{
		$this->ctBody.=$value;
	}

	public function setLogged($value)
	{
		$this->logged = $value;
	}

	public function addHeader($value)
	{
		$this->head .= $value;
	}

	public function addMenuItem($key, $lib, $link)
	{
		$this->arMainMenu[$key] = array();
		$this->arMainMenu[$key]['lib'] = $lib;
		$this->arMainMenu[$key]['link'] = $link;
	}

	public function addTranslateText($tag, $text)
	{
		$this->translator[$tag] = $text;
	}

	public function __get($name)
	{
		if (array_key_exists($name, $this->contentData)) {
			return $this->contentData[$name];
		}
		return '';
	}

	public function getUrlVar($param)
	{

		if (isset($this->urlVars[$param]))
		return $this->urlVars[$param];
		else
		return '';
	}
	
	public function getParamValue($name, $method = 'GET', $default = '')
	{
		if ($name != '') {
			switch ($method) {
			case 'GET':
				$input = &$_GET;
				break;
			case 'POST':
				$input = &$_POST;
				break;
			default:
				$input = &$_REQUEST;
				break;
			}

			if (!isset($input[$name])) {
				$input[$name] = $default;
			}

			return $input[$name];
		} else {
			return $default;
		}
	}

	public function getJsCode()
	{
		return '<script type="text/javascript">' . $this->jsCode . '</script>';
	}

	public function getCssCode()
	{
		return '<style type="text/css">' . $this->cssCode . '</style>';
	}

	public function getLogged()
	{
		return $this->logged;
	}

	public function getDbPdo()
	{
		return $this->dbPdo;
	}

	public function getTplPath()
	{
		return $this->tplBasePath . $this->tplPath;
	}

	public function getGlobalComponentsPath()
	{

		return $this->pathWebApp . $this->globalDirComponents;
	}

	public function getLibViewPath()
	{

		return $this->pathWebApp . $this->pathView;
	}

	public function getLibModelPath()
	{

		return $this->pathWebApp . $this->pathModel;
	}

	public function getHead()
	{
		return $this->head;
	}

	public function getContentTop()
	{
		return $this->ctTop;
	}

	public function getContentBody()
	{
		return $this->ctBody;
	}

	public function getMainMenu()
	{
		return $this->ctMainMenu;
	}

	public function getContentBottom()
	{
		return $this->ctBottom;
	}

	public function getIncludeContents($view, $filename)
	{
		ob_start();
		include $filename;
		return ob_get_clean();
	}

	public function getTranslation($text)
	{
		if (is_array($this->translator)) {
			if (array_key_exists($text, $this->translator)) {
				return $this->translator[$text];
			} else {
				return $text;
			}
		} else {
			return $text;
		}
	}

	public function checkUser()
	{
		if (isset($_SESSION['userid']))
		$id = $_SESSION['userid'];
		else
		$id = - 1;

		$user = new GUser($this->dbPdo);

		if ($id > -1) {
			$loadStatus = $user->loadUserWithId($id);
			$this->setLogged($loadStatus);
		} else {
			$user->loadVisitorData();
		}
		$this->user = $user;
	}

	public function execute()
	{

		$ctrlName = 'C' . strtoupper(substr($this->component, 0, 1)) . substr($this->component, 1);

		if (file_exists($this->localDirComponents . '/' . $this->component . '/c_' . $this->component . '.php')) {
			include_once($this->localDirComponents . '/' . $this->component . '/c_' . $this->component . '.php');
		} else if (file_exists($this->getGlobalComponentsPath() . '/' . $this->component . '/c_' . $this->component . '.php')) {
			include_once($this->getGlobalComponentsPath() . '/' . $this->component . '/c_' . $this->component . '.php');
		} else {
			if (isset($this->defaultComponent) && $this->defaultComponent != '') {
				$this->component = $this->defaultComponent;
				$this->action = $this->defaultAction;

				if (isset($this->component)) {
					include_once($this->localDirComponents . '/' . $this->component . '/c_' . $this->component . '.php');
					$ctrlName = 'C' . strtoupper(substr($this->component, 0, 1)) . substr($this->component, 1);
				}
			}
		}

		if (class_exists($ctrlName)) {
			$this->controller = new $ctrlName($this);
			if (method_exists($this->controller, $this->action)) {
				$methodeName = $this->action;
				$this->controller->$methodeName();
			} else if (method_exists($this->controller, 'defaultAction')) {
				$this->controller->defaultAction();
			}
		} else {
			$this->doDie('WrongWay');
		}
		$this->loadMainMenu();
		$this->loadComponentMenu();
		$this->loadActionMenu();
		if (file_exists('configuration/modules.conf.php'))
		include_once('configuration/modules.conf.php');
		if (isset($this->modules)) {
			$this->loadModules();
		}
	}

	public function loadMainMenu()
	{
		$filename = $this->pathMenu . 'main.menu.php';
		if (file_exists($filename))
		include_once($filename);
	}

	public function loadComponentMenu()
	{
		$filename = $this->pathMenu . $this->component . '.menu.php';
		if (file_exists($filename))
		include_once($filename);
	}

	public function loadActionMenu()
	{
		$filename = $this->pathMenu . $this->component . '_' . $this->action . '.menu.php';
		if (file_exists($filename))
		include_once($filename);
	}

	public function doDie($message)
	{
		if (!$this->debug)
		Die($message);
	}

	public function loadTemplate()
	{

		switch ($this->modeResponse) {
		case 'template':
			$cTplJsFile = $this->getTplPath() . 'js/' . $this->component . '.js';
			$aTplJsFile = $this->getTplPath() . 'js/' . $this->component . '_' . $this->action . '.js';
			if (file_exists($cTplJsFile)) {
				//$this->jsCode.=file_get_contents($cTplJsFile);
				$this->addJsFile($cTplJsFile);
			}
			if (file_exists($aTplJsFile)) {
				//$this->jsCode.=file_get_contents($aTplJsFile);
				$this->addJsFile($aTplJsFile);
			}
			$cSiteJsFile = 'js/' . $this->component . '.js';
			$aSiteJsFile = 'js/' . $this->component . '_' . $this->action . '.js';
			if (file_exists($cSiteJsFile)) {
				//$this->head .= '<script type="text/javascript" src="' . $cSiteJsFile . '"></script>';
				$this->addJsFile($cSiteJsFile);
			}
			if (file_exists($aSiteJsFile)) {
				//$this->head .= '<script type="text/javascript" src="' . $aSiteJsFile . '"></script>';
				$this->addJsFile($aSiteJsFile);
			}

			$cTplCssFile = $this->getTplPath() . 'css/' . $this->component . '.css';
			$aTplCssFile = $this->getTplPath() . 'css/' . $this->component . '_' . $this->action . '.css';
			$templateCssFile = $this->getTplPath() . 'css/' . rtrim($this->tplPath,'/'). '.css';
			if (file_exists($templateCssFile)) {
			$this->addCssFile($templateCssFile);
				
			}
			if (file_exists($cTplCssFile)) {
			$this->addCssFile($cTplCssFile);
				
			}
			if (file_exists($aTplCssFile)) {
			$this->addCssFile($aTplCssFile);
				
			}

			$cSiteCssFile = 'css/' . $this->component . '.css';
			$aSiteCssFile = 'css/' . $this->component . '_' . $this->action . '.css';
			if (file_exists($cSiteCssFile)) {
				$this->addCssFile($cSiteCssFile);
			}
			if (file_exists($aSiteCssFile)) {
				$this->addCssFile($aSiteCssFile);
			}

	

			if (trim($this->cssCode) != '')
			$this->head .= '<style type="text/css">' . $this->cssCode . '</style>';

			$templateFile = $this->getTplPath() . $this->tplIndex;

			if (file_exists($templateFile)) {
				include($templateFile);
			} else {
				$this->doDie('No template');
			}
			break;

		case 'rest':
			header("Content-Type:text/xml");
			echo $this->pContentBody;

			break;
		case 'xml':
			header("Content-Type:text/xml");
			echo $this->pContentBody;

			break;
		case 'onlybody':
			echo $this->pContentBody;
			break;
		}
	}

	public function loadConf($filename)
	{
		if (file_exists($filename))
		include_once($filename);
	}

	public function checkBrowser()
	{
		include_once('Browser.php');
		$browser = new Browser();
		$this->browser = $browser->getBrowser();
		$this->browserVersion = $browser->getVersion();
	}

	public function loadModules()
	{

		foreach ($this->modules as $name => $module) {

			$languageFile = 'languages/' . $this->language . '/' . $name . '.mod.php';
			if (file_exists($languageFile)) {
				include_once($languageFile);
			}

			$configurationFile = 'configuration/' . $name . '.mod.conf.php';
			if (file_exists($configurationFile)) {
				include_once($configurationFile);
			}
			$moduleFile = 'modules/' . $name . '.mod.php';
			if (file_exists($moduleFile))
			include_once($moduleFile);
		}
	}

	public function redirect($redirection)
	{
		header('Location: ' . $redirection);
		exit;
	}

}

?>
