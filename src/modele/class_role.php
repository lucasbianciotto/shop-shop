<?php

class Role {

    private $db;
    private $insert;
    private $select;
    private $connect;
    private $update;
    private $selectById;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $this->db->prepare("insert into role(libelle) values (:libelle)");
        $this->connect = $this->db->prepare("select libelle from role where libelle=:libelle");
        $this->select = $db->prepare("select id, libelle from role order by libelle");
        $this->selectById = $db->prepare("select id, libelle from role where id=:id");
        $this->update = $db->prepare("update role set libelle=:libelle where id=:id");
    }

    public function insert($libelle) {
        $r = true;
        $this->insert->execute(array(':libelle' => $libelle));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function connect($libelle) {
        $unRole = $this->connect->execute(array(':libelle' => $libelle));
        if ($this->connect->errorCode() != 0) {
            print_r($this->connect->errorInfo());
        }
        return $this->connect->fetch();
    }

    public function select() {
        $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
    }


}





?>