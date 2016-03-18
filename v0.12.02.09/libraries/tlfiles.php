<?php
function advScanDir($dir, $mode,$stop=0)
{
	// ajout d'un compteur permettant a la fonction de s'arreter apr�s avoir r�cup�r� $stop items
	$cpt=0;
   // creation du tableau qui va contenir les elements du dossier
   $items = array();

   // ajout du slash a la fin du chemin s'il n'y est pas
   if(!preg_match("/^.*\/$/", $dir)) $dir .= '/';

   // Ouverture du repertoire demand�
   $handle = opendir($dir);

   // si pas d'erreur d'ouverture du dossier on lance le scan
   if($handle != false)
   {
   	// Parcours du repertoire
   	while($item = readdir($handle))
   	{
   		if($item != '.' && $item != '..')
   		{
   			// selon le mode choisi
   			switch($mode)
   			{
   				case 'directory' :
   					if(is_dir($dir . $item))
   					$items[] = $item;
   					break;

   				case 'file' :
   					if(!is_dir($dir . $item))
   					$items[] = $item;
   					break;

   				case 'all' :
   					$items[] = $item;
   			}
   			$cpt++;
   			if (($stop>0) && ($cpt >= $stop))
   			{
   				return $items;
   				exit;
   			}

   		}
   	}

      // Fermeture du repertoire
      closedir($handle);
      return $items;
   }
   else return false;
}

/*function addfoldertozip($dir, $zipArchive, $zipdir = '')
{
//echo $dir.'<br>';
if(is_dir($dir))
{
if($dh = opendir($dir))
{

//Add the directory
//$zipArchive->addEmptyDir($dir);

// Loop through all the files
while(($file = readdir($dh)) !== false)
{
echo $file.'<br>';
//If it's a folder, run the function again!
if(!is_file($dir . $file))
{
// Skip parent and root directories
if(($file !== ".") && ($file !== ".."))
{
addfoldertozip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");

}

}
else
{
// Add the files
$zipArchive->addFile($dir . $file, $zipdir . $file);

}
}
}
}
}
*/
function addFolderToZip($dir, $zipArchive)
{
  $dir= str_replace('/','\\',$dir);

   if(is_dir($dir))
   {
      if($dh = opendir($dir))
      {

         //Add the directory
         echo 'dir' . $dir.'<br>';
         $zipArchive->addEmptyDir(substr($dir,3));

         // Loop through all the files
         while(($file = readdir($dh)) !== false)
         {
            // echo $file.'<br>';
            //If it's a folder, run the function again!
            if(!is_file($dir . $file))
            {
               // Skip parent and root directories
               if(($file !== ".") && ($file !== ".."))
               {
                  addFolderToZip($dir . $file . "/", $zipArchive);
               }

            }
            else
            {
               // Add the files
               $zipArchive->addFile($dir . $file);
               echo 'fichier '.$dir . $file.'<br>';
            }
         }
      }
   }
}
function unzip($file, $path = '', $effacer_zip = false)
{/*M�thode qui permet de d�compresser un fichier zip $file dans un r�pertoire de destination $path
   et qui retourne un tableau contenant la liste des fichiers extraits                                                                                ?> Si $effacer_zip est �gal � true, on efface le fichier zip d'origine $file*/

   $tab_liste_fichiers = array();//Initialisation

   $zip = zip_open($file);

   if($zip)
   {
      while($zip_entry = zip_read($zip))//Pour chaque fichier contenu dans le fichier zip
      {
         if(zip_entry_filesize($zip_entry) > 0)
         {
            $complete_path = $path . dirname(zip_entry_name($zip_entry));

            /*On supprime les �ventuels caract�res sp�ciaux et majuscules*/
            $nom_fichier = zip_entry_name($zip_entry);

            $nom_fichier = strtr($nom_fichier, "�����������������������������������������������������", "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");

            $nom_fichier = strtolower($nom_fichier);
            // echo  $nom_fichier .'<br>';
            //$nom_fichier = ereg_replace('[^a-zA-Z0-9.]', '-', $nom_fichier);
            echo $nom_fichier . '<br>';
            /*On ajoute le nom du fichier dans le tableau*/
            array_push($tab_liste_fichiers, $nom_fichier);

            $complete_name = $path . $nom_fichier;//Nom et chemin de destination

            if(!file_exists($complete_path))
            {
               $tmp = '';
               foreach(explode('/', $complete_path) AS $k)
               {
                  $tmp .= $k . '/';

                  if(!file_exists($tmp))
                  {
                     mkdir($tmp, 0755);
                  }
               }
            }

            /*On extrait le fichier*/
            if(zip_entry_open($zip, $zip_entry, "r"))
            {
               $fd = fopen($complete_name, 'w');

               fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));

               fclose($fd);
               zip_entry_close($zip_entry);
            }
         }
      }

      zip_close($zip);

      /*On efface �ventuellement le fichier zip d'origine*/
      if($effacer_zip === true)
         unlink($file);
   }

   return $tab_liste_fichiers;
}
function cutfile($file, $delimiter, $function)
{
   $handle = fopen($file, "r");
   $buffer='';
//   while(!feof($handle))
   while(!feof($handle))
   {
      $buffer .= fgets($handle, 256);
      $pos = strpos($buffer, $delimiter);
      if($pos === false)
      {

      }
      else
      {
         $element = substr($buffer, 0, $pos + strlen($delimiter));
//         $buffer = substr($buffer, $pos + strlen($delimiter) +1);
         $buffer = substr($buffer, $pos + strlen($delimiter) );
         $function($element);
      }
   }
   if ($buffer<>'')
   $function($buffer);


   fclose($handle);

}

function getfilefromftp ($ftpserver,$user,$pwd,$distpath,$srcfilepattern,$wdir,$logfile)
{
	$ftp = @ftp_connect($ftpserver);
	if($ftp)
	{
		$ftplog = @ftp_login($ftp, $user, $pwd);
		if($ftplog)
		{
			$filelist=ftp_nlist($ftp,$distpath);
			foreach ($filelist as $filename)
			{
				$pattern = '#'.$srcfilepattern.'#';
				preg_match($pattern,$filename,$matches);
				if (count($matches)>0)
				break ;
				else $filename='';
			}
			echo '<br />';
			ftp_chdir($ftp,$distpath);

			if (strrpos($filename,'/')!==false)
			 $filename=substr($filename,strrpos($filename,'/')+1);
			 echo $filename;
			if (@ftp_get($ftp, $wdir.$filename, $filename, FTP_BINARY))
			{
				@ftp_close($ftp);
			}
			else
			{
				@ftp_close($ftp);
				$info = 'No file to get today!';
				file_put_contents($logfile, date('Y_m_d_H_i') . ' '.$info."\n");
			}
		}
		else
		{
			@ftp_close($ftp);
			$info = 'Error connecting with user '.$conf->ftpuser1;
			file_put_contents($logfile, date('Y_m_d_H_i') . ' '.$info."\n");
		}
	}
	else
	{
		$info = 'Error when connecting to the server '.$conf->ftpserver.':'.$conf->ftpport."\n";
		file_put_contents($logfile, date('Y_m_d_H_i') . ' '.$info);
	}
	return ($filename);
}

function tarfiles ($dirtozip,$files,$zipname)
{
	$cmd='cd '.$dirtozip.';tar cfvz '.$zipname.' '.$files;
	 exec($cmd);
	 //echo $cmd;
}

function untarfiles ($filesdir,$zipname)
{
	$cmd='cd '.$filesdir.';tar xfvz '.$zipname;
	 exec($cmd);
	 //echo $cmd;
}

function deletefiles ($dirtodel,$files)
{
	$cmd='cd '.$dirtodel.';rm '.$files;
	 exec($cmd);
	 //echo $cmd;
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!deleteDirectory($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!deleteDirectory($dir . "/" . $item)) return false;
            };
        }
        return rmdir($dir);
    }

function sshcopy($host,$port,$username,$password,$local_file,$remote_file)
{
    $connection=ssh2_connect($host,$port);
    ssh2_auth_password($connection, $username, $password);
    return ssh2_scp_send($connection, $local_file, $remote_file);

}

?>