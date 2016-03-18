<?php

class GUser {

    private $id;
    private $login;
    private $pass;
    private $name;
    private $firstname;
    private $userConf;
    private $dbPdo;

    public function __construct($dbPdo) {
        $this->dbPdo = $dbPdo;
    }

    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getName() {
        return $this->name;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function loadUserConfiguration($confPath) {
        if (file_exists($confPath)) {
            require_once($confPath);
            $this->userConf = new Configuration();
            return $this->userConf;
        } else {
            return false;
        }
    }

    private function loadUser($sql, $id = '', $login = '', $password = '') {
        $sqlPrep = $this->dbPdo->prepare($sql);
        if ($id != '')
            $sqlPrep->bindParam(':id', $id, PDO::PARAM_INT);
        if ($login != '')
            $sqlPrep->bindParam(':login', $login, PDO::PARAM_STR);
        if ($password != '')
            $sqlPrep->bindParam(':password', $password, PDO::PARAM_STR);

        $execStatus = $sqlPrep->execute();

        $row = $sqlPrep->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id = $row['ID'];
            $this->login = $row['LOGIN'];
            $this->name = $row['NAME'];
            $this->firstname = $row['FIRSTNAME'];
            $this->email = $row['EMAIL'];
            $this->lastVisitDate = $row['LAST_VISIT_DATE'];
            $this->usertype = $row['USER_TYPE'];
            
            $_SESSION['userid'] = $row['ID'];
            $_SESSION['dbsource'] = $row['DBS_ID'];
            $result = true;
        }
        else
            $result = false;

        $sqlPrep->closeCursor();

        return $result;
    }

    public function loadUserWithPass($login, $pass) {
        $sql = 'SELECT * FROM `PROFILES` WHERE `LOGIN` = :login AND `PASSWORD` = :password';
        return $this->loadUser($sql, '', $login, $pass);
    }

    public function loadVisitorData() {
        $this->id = -1;
        $this->login = '';
        $this->pass = '';
        $this->name = '';
        $this->firstname = 'visitor';
    }

    public function loadUserWithId($id) {
        $sql = 'SELECT * FROM `PROFILES` WHERE `ID` = :id';
        return $this->loadUser($sql, $id);
    }

    public function logoutUser() {
        unset($_SESSION['userid']);

        return true;
    }

    public function __destruct() {
        
    }

}

?>