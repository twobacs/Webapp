<?php
class dbmodel
{
	/**
	 MC 03/03/2010 Attention !!!!!!!!!!!!!!!!! Pour pouvoir utiliser cette classe sans problème, il faut absolument que la table gérée contienne 1 record ! Sans quoi le loadschema ne marchera pas et le buildquery non plus !
	 **/
	var $dbdf;

	function dbmodel($dbconnexion = null , $server = '', $login = '', $pass = '', $path = '', $debug = 0)
	{

		if(isset($dbconnexion))
		{
			$this->dbdf = $dbconnexion;
			$this->loadschema();
		}
		/*else
		 {
		 include_once('../tllib/firebird.class.php');
		 $this->dbdf = new firebird($server, $login, $pass, $path, $debug, 0);
		 }
		 $this->loadschema();
		 */
	}

	function loadschema($forcedb = false)
	{
		if(file_exists($this->tablename . '.sch'))
		{
			file_get_contents($this->tablename . '.sch');
		}
		else
		{
			$this->dbdf->requete('select first(1) * from ' . $this->tablename, 'init');
			$row = $this->dbdf->resultat('init');
			//print_r($row);
			$this->dbdf->setschema($row, $this, 'init');
			//var_dump($this);

		}
	}

	function buildinsertsql()
	{
		$sqlfields = '';
		$sqlfieldsvalue = '';
		$sql = '';
		foreach($this as $name => $value)
		{
			if(substr($name, 0, 2) == 'f_')
			{
				//echo $name . ' - ' . $value.'<br />';
				$nameinfo = 'i_' . substr($name, 2);
				//echo $nameinfo . '||';print_r($this->$nameinfo)	;
				$params = $this->$nameinfo;
				$sql .= substr($name, 2) . '=' . $this->dbdf->preparevalue($params, $value) . ',';
				$sqlfields .= substr($name, 2) . ',';
				//echo '<br />prep: ' . $this->dbdf->preparevalue($params, $value);
				$sqlfieldsvalue .= $this->dbdf->preparevalue($params, $value) . ',';
				//echo $name.'='.$value;
			}
		}
		$sql = 'insert into ' . $this->tablename . ' (' . substr($sqlfields, 0, - 1) . ') values (' . substr($sqlfieldsvalue, 0, - 1) . ')';
		//echo $sql;
		return $sql;
	}

	function buildupdatesql()
	{
		$sql = 'update ' . $this->tablename . ' set ';

		foreach($this as $name => $value)
		{
			if(substr($name, 0, 2) == 'f_')
			{
				$nameinfo = 'i_' . substr($name, 2);
				$params = $this->$nameinfo;
				$sql .= substr($name, 2) . '=' . $this->dbdf->preparevalue($params, $value) . ',';
			}
		}
		//echo $sql.'<br/>';
		return substr($sql, 0, - 1);

	}

	function clear()
	{
		foreach($this as $name => $value)
		{
			if(substr($name, 0, 2) == 'f_')
			{
				unset($this->$name);
			}
		}
	}

}
?>