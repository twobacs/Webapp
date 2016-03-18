<?php

class VBase {

    function __construct($appli, $model) {
        $this->appli = $appli;
        $this->model = $model;
        //  $this->dbPdo=$appli->getDbPdo();
    }

    function __destruct() {
        //   echo 'destruct base view <br />';
    }

    function setContentBody($value) {
        $this->appli->setContentBody($value);
    }

    function addContentBody($value) {
        $this->appli->addContentBody($value);
    }

}

?>