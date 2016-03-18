<?php
class mysql
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
   function mysql($serveur, $utlisateur, $password, $bd, $debug, $erreur)
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

   //fonction de connection a mysql
   function connection()
   {
      if($this->connection_verif == "0")
      {
         $this->connection_sql = mysql_connect($this->sql_serveur, $this->sql_utilisateur, $this->sql_password);
         if(!$this->connection_sql)
         {
            $this->mysql_erreur('error on connexion');
         }
         else
         {
            $this->selection_bd();
         }
      }
   }

   //fonction de selection de la base de donnée
   function selection_bd()
   {

      $this->select_bd = mysql_select_db($this->sql_bd, $this->connection_sql);
      if(!$this->select_bd)
      {
         $this->mysql_erreur();
      }
      else
      {
         $this->connection_verif = 1;
      }
   }

   //fonction de déconnexion de la base de donnée
   function deconnexion()
   {
      mysql_close($this->connection_sql);
   }

   //fonction d'execution de requête
   function requete($requete, $p)
   {
      $this->resultat[$p] = mysql_query($requete);
      $this->nb_requete++;
      if(!$this->resultat[$p])
      {
         $this->mysql_erreur($requete);
      }
   }

   //fontion qui retourne les donnée dans un tableau grace a fetch array
   function resultat($p)
   {
      return mysql_fetch_array($this->resultat[$p]);
   }

   //fonction permettant de compter le nombre de resultat trouvé
   function nb_resultat($p)
   {
      return mysql_num_rows($this->resultat[$p]);
   }
   //function d'affichage des erreur mysql
   function mysql_erreur($mess = '')
   {
      if($this->sql_debug == 0)
      {
         echo $this->message_erreur;
      }
      elseif($this->sql_debug == 1)
      {
         $this->erreur = mysql_error($this->connection_sql);
         $message = "une erreur mysql est survenue : <br /> <form name='mysql'><textarea rows='15' cols='60'>" . $this->erreur . "-----" . $mess . "</textarea></form>";
         echo $message;
      }
   }
   function row2class($row, $object)
   {
      if(!$row)
      {
         return false;
      }
      else
      {
         foreach($row as $key => $value)
         {
            $object->$key = $value;
         }
         return true;
      }
   }
}
?>