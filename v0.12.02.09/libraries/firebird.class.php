<?php
class firebird
{
   var $sql_serveur;
   var $sql_utlisateur;
   var $sql_password;
   var $sql_bd;
   var $connection_sql;
   var $select_bd;
   var $resultat;
   var $sql_debug;
   var $connection_verif;
   var $nb_requete;
   var $erreur;
   var $message_erreur;

   //constructeur
   function firebird($serveur, $utlisateur, $password, $bd, $debug = '', $erreur = '')
   {
      $this->sql_serveur = $serveur;
      $this->sql_utilisateur = $utlisateur;
      $this->sql_password = $password;
      $this->sql_bd = $bd;
      $this->sql_debug = $debug;
      $this->message_erreur = $erreur;
      $this->resultat = array();
      $this->connection_verif = 0;
      $this->connection();
   }

   //fonction de connection a  firebird sql
   function connection()
   {
      if($this->connection_verif == "0")
      {
         $this->connection_sql = ibase_connect($this->sql_serveur . ':' . $this->sql_bd, $this->sql_utilisateur, $this->sql_password);
         if(!$this->connection_sql)
         {
            $this->sql_erreur('error on connexion');
         }
         else
         {
            //$this->selection_bd();  pas util en firebird
         }
      }
   }

   //fonction de selection de la base de donnée
   function selection_bd()
   {

      $this->select_bd = mysql_select_db($this->sql_bd, $this->connection_sql);
      if(!$this->select_bd)
      {
         $this->ibase_erreur();
      }
      else
      {
         $this->connection_verif = 1;
      }
   }

   //fonction de déconnexion de la base de donnée
   function deconnexion()
   {
      ibase_close($this->connection_sql);
   }

   //fonction d'execution de requête
   function requete($requete, $p)
   {
      $result = true;
      $this->resultat[$p] = ibase_query($this->connection_sql, $requete);
     // echo $requete.'<br/>';
      $this->nb_requete++;
      if(!$this->resultat[$p])
      {
         $this->sql_erreur($requete);
         $result = false;
      }
      return $result;

   }

   //fontion qui retourne les donnée dans un tableau grace a fetch array
   function resultat($p)
   {
      return ibase_fetch_assoc($this->resultat[$p], IBASE_TEXT);
   }

   //fonction permettant de compter le nombre de resultat trouvé
   function nb_resultat($p)
   {
      return 0;//@mysql_num_rows($this->resultat[$p]);
   }
   //function d'affichage des erreur mysql
   function sql_erreur($mess = '')
   {
      if($this->sql_debug == 0)
      {
         echo $this->message_erreur;
      }
      elseif($this->sql_debug == 1)
      {
         $this->erreur = ibase_errmsg();
         $message = "une erreur firebird est survenue : <br /> <form name='firebird'><textarea rows='15' cols='60'>" . $this->erreur . "-----" . $mess . "</textarea></form>";
         echo $message;
      }
   }
   function row2class($row, $object, $fieldslower = true, $prefixed = false, $resultat = '', $table = '')
   {
      if(!$row)
      {
         return false;
      }
      else
      {
         $i = 0;
         foreach($row as $key => $value)
         {
            $keyfield = $key;
            if($fieldslower)
            {
               $keyfield = strtolower($keyfield);
            }

            $keyinfo = 'i_' . $keyfield;
            /* if($resultat <> '')
            {
            $object->$keyinfo = ibase_field_info($this->resultat[$resultat], $i);
            }
            */
            $prefixe = '';
            if($prefixed)
            {
               //$params = $object->$keyinfo;
               //if($params[2] == strtoupper($table))
               if(isset($object->$keyinfo))
                  $prefixe = 'f_';
               else
                  $prefixe = 'j_';

            }
            $keyfield = $prefixe . $keyfield;
            $object->$keyfield = $value;
            $i++;
         }
         return true;
      }
   }
   function setschema($row, $object, $resultat)
   {
      $i = 0;
      foreach($row as $key => $value)
      {
         if($resultat <> '')
         {
            $keyfield = strtolower($key);
            $keyinfo = 'i_' . $keyfield;
            // print_r(ibase_field_info($this->resultat[$resultat], $i));
            // echo '<br>';
            $object->$keyinfo = ibase_field_info($this->resultat[$resultat], $i);
         }
         $i++;

      }
   }
   function preparevalue($params, $value)
   {
      switch($params[4])
      {
         case 'VARCHAR':
            if(!isset($value))
               return 'null';
            return '\'' . $this->cleanquotes($value) . '\'';
            break;
         case 'CHAR' :
            if(!isset($value))
               return 'null';
            return '\'' . $this->cleanquotes($value) . '\'';
            break;
         case 'INTEGER' :
            if(!is_int($value))
               $value = 'null';
            return $value;
            break;
         case 'SMALLINT' :
            if(!is_int($value))
               $value = 'null';
            return $value;
            break;
         case 'TIMESTAMP' :
            if($value == '')
               return 'null';
            else
               return '\'' . $value . '\'';
            break;
         case 'BLOB':

            return '\'' . $this->cleanquotes($value) . '\'';

            break;
      }


   }
   function cleanquotes($chaineanettoyer)
   {
      // MC 06-03-09 nettoyage quotes
      $retour = stripslashes($chaineanettoyer);
      $retour = str_replace('\'', '\'\'', $retour);
      return($retour);
      // MC 06-03-09 Fin nettoyage quotes ---
   }

}
?>