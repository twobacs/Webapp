<?php
include_once('mysql.class.php');

class datalog
{
   var $dbmy;

   function datalog($name)
   {
      $this->exportname = $name;
      $this->importname = $name;
      $this->dbmy = new mysql('192.168.20.137', 'tl', 'tlmysql', 'datalog', 1, 0);

   }


   function addExportError($ean, $errorlib, $valuefield, $info = '')
   {
      $sql = 'insert into exporterrors (exportdate,ean,errorlib,valuefield,name,info) values (curdate(),"' . $ean . '","' . $errorlib . '","' . $valuefield . '","' . $this->exportname . '","' . $info . '")';
      $this->dbmy->requete($sql, 'inserterror');
      // print_r($this->dbmy);
   }
   function updateExportError($ean, $errorlib, $valuefield,$infofield='')
   {
      //$sql='insert into exporterrors (exportdate,ean,errorlib,valuefield,name) values (curdate(),"'.$ean.'","'.$errorlib.'","'.$valuefield.'","'.$name.'")';
      $sql = 'update exporterrors set exportdate=curdate(),valuefield="' . $valuefield . '",info="'.$infofield.'"  where ean="' . $ean . '" and name="' . $this->exportname . '" and errorlib="' . $errorlib . '"';
      $this->dbmy->requete($sql, 'updateerror');
      // print_r($this->dbmy);
   }

   function deleteEanExportError($ean)
   {
      $sql = 'delete from exporterrors where ean="' . $ean . '" and name="' . $this->exportname . '"';
      $this->dbmy->requete($sql, 'errordelete');

   }

   function addUniqueExportError($ean, $errorlib, $valuefield, $info = '')
   {
      $select = 'select * from exporterrors where name="' . $this->exportname . '" and ean="' . $ean . '" and errorlib="' . $errorlib . '"';
      //echo $select;
      $this->dbmy->requete($select, 'select');
      if($row = $this->dbmy->resultat('select'))
      {
         $this->updateExportError($ean, $errorlib, $valuefield,$info);
      }
      else
      {
         $this->addExportError($ean, $errorlib, $valuefield, $info);
      }
   }

   function addImportError($ean, $errorlib, $valuefield, $info)
   {
      $sql = 'insert into importerrors (importdate,ean,errorlib,valuefield,name,info) values (curdate(),"' . $ean . '","' . $errorlib . '","' . $valuefield . '","' . $this->importname . '","' . $info . '")';
      $this->dbmy->requete($sql, 'inserterror');
      // print_r($this->dbmy);
   }
   function updateImportError($ean, $errorlib, $valuefield)
   {
      //$sql='insert into exporterrors (exportdate,ean,errorlib,valuefield,name) values (curdate(),"'.$ean.'","'.$errorlib.'","'.$valuefield.'","'.$name.'")';
      $sql = 'update importerrors set importdate=curdate(),valuefield="' . $valuefield . '" where ean="' . $ean . '" and name="' . $this->importname . '" and errorlib="' . $errorlib . '"';
      $this->dbmy->requete($sql, 'updateerror');
      // print_r($this->dbmy);
   }
   function deleteEanImportError($ean)
   {
      $sql = 'delete from importerrors where ean="' . $ean . '" and name="' . $this->importname . '"';
   }
   function addUniqueImportError($ean, $errorlib, $valuefield, $info = '')
   {
      $select = 'select * from importerrors where name="' . $this->importname . '" and ean="' . $ean . '" and errorlib="' . $errorlib . '"';
      //echo $select;
      $this->dbmy->requete($select, 'select');
      if($row = $this->dbmy->resultat('select'))
      {
         $this->updateImportError($ean, $errorlib, $valuefield);
      }
      else
      {
         $this->addImportError($ean, $errorlib, $valuefield, $info);
      }
   }



   function addExportLog($action, $countsuccess, $counterrors)
   {
      if(!is_numeric($countsuccess))
         $countsuccess = 0;
      if(!is_numeric($counterrors))
         $counterrors = 0;
      $sql = 'insert into exportlog (exportdate,name,countsuccess,counterrors,action) values (now(),"' . $this->exportname . '",' . $countsuccess . ',' . $counterrors . ',"' . $action . '")';
      $this->dbmy->requete($sql, 'insertlog');
   }

   function addImportLog($action, $countsuccess, $counterrors)
   {
      if(!is_numeric($countsuccess))
         $countsuccess = 0;
      if(!is_numeric($counterrors))
         $counterrors = 0;
      $sql = 'insert into importlog (importdate,name,countsuccess,counterrors,action) values (now(),"' . $this->importname . '",' . $countsuccess . ',' . $counterrors . ',"' . $action . '")';
      $this->dbmy->requete($sql, 'insertlog');
   }


   function write_apache2proc_use($status)
   {
      $tmp = posix_getpid();
      //echo $tmp;
      $scriptname = $_SERVER['SCRIPT_FILENAME'];
      $scriptname = $status . ' ' . $scriptname;
      //echo "<br>$scriptname<br>";
      $output = array();
      exec('ps aux | grep ' . $tmp . ' | grep apache2 | awk \'{print $2"\t"$4"\t"$11}\'', $output);
      foreach($output as $val)
      {
         if(strpos($val, 'apache2') == true)
         {
            $valeur = $val;
            break;
         }
      }

      // $this-dbmy = new mysql('localhost', 'root', 't!tel!ve', 'datalog', 1, $error);
      $req = "insert into processlog (scriptname,writetime,memory_used,processid) values ('$scriptname',NOW(),'$valeur','$tmp');";
      //echo $req;
      $this->dbmy->requete($req, 'insertprocess');
      //$rowepa = $dbmysql->resultat('checkepa2');
   }

   function addFirebirdError($errortxt, $sqltxt)
   {
      $sql = 'insert into firebirderrors (errordate,scriptname,errortxt,sqltxt) values (now(),"' .
      $_SERVER[PHP_SELF] . '","' . addslashes($errortxt) . '","' . addslashes($sqltxt) . '")';
      $this->dbmy->requete($sql, 'inserterror');
   }
   function loadFirebirdErrors($filters = '', $searchinsql='')
   {
  // echo $filters;
      $sql = 'select * from firebirderrors where pkey=pkey ';

      $tbfilters = explode('.', $filters);

      foreach($tbfilters as $filter)
      {
         switch($filter)
         {
            case 'noprimary' :
               $sql .= 'and errortxt not like "violation of PRIMARY%" ';
            case  'noindexduplicate':
              $sql.=' and errortxt not like "attempt to store duplicate value (visible to active transactions) in unique index% "';

             break;

            default:
               //  $sql = ' select * from firebirderrors';

         }
      }
      $tbsearchinsql = explode('.', $searchinsql);

      foreach($tbsearchinsql as $search)
      {
      $sql.=' and CONCAT(scriptname,errortxt,sqltxt) like "%'.$search.'%"';
      }

      $sql.=' order by pkey desc';

      $this->dbmy->requete($sql, 'firebirderrors');
   }

   function loadExportErrors($filters = '', $searchinsql='',$nrpage=0)
   {
  // echo $filters;
     // echo 'hello';
     // exit;
      $sql = 'select * from exporterrors where ean=ean ';

      $tbfilters = explode('.', $filters);

      foreach($tbfilters as $filter)
      {
         switch($filter)
         {
            case 'noprimary' :
               $sql .= 'and errortxt not like "violation of PRIMARY%" ';
            case  'noindexduplicate':
              $sql.=' and errortxt not like "attempt to store duplicate value (visible to active transactions) in unique index% "';

             break;

            default:
               //  $sql = ' select * from firebirderrors';

         }
      }
      $tbsearchinsql = explode('.', $searchinsql);

      foreach($tbsearchinsql as $search)
      {
      $sql.=' and CONCAT(ean,errorlib,name,info) like "%'.$search.'%"';
      }

      $sql.=' order by exportdate desc limit '.($nrpage*1000).',1000';

      $this->dbmy->requete($sql, 'exporterrors');
      return 'exporterrors';
      //print_r($this->dbmy->resultat('exporterrors'));
   }


}


?>