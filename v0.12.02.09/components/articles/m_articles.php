<?php

include_once('m_base.php');

class MArticles extends MBase {

    function __construct($appli) {
        parent::__construct($appli);
    }

    function load($art_name) {
        
        $filename = $this->appli->pathArticles . $art_name . '.php';
        if (file_exists($filename)) {
            include_once($filename);
            return true;
        } else {
            $filename = $this->appli->pathArticles . $art_name . '.txt';
            if (!file_exists($filename)) {
     //           $filename = $this->appli->pathArticles . 'error.txt';
                return false;
            }
            else
            {
                $this->data = file_get_contents($filename);
                return true;
            }
        }
    }

}
?>