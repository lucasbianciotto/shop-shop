<?php

class Produit {

    private $db;
    private $insert;
    private $select;
    private $connect;
    private $update;
    private $selectById;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $this->db->prepare("insert into produit(designation, description, prix, idType) values (:designation, :description, :prix, :idType)");
        $this->connect = $this->db->prepare("select * from produit where designation=:designation");
        $this->select = $db->prepare("select * from produit order by designation");
        $this->selectById = $db->prepare("select * from produit where id=:id");
        $this->update = $db->prepare("update produit set designation=:designation, description=:description, prix=:prix, idType=:idType where id=:id");

    }

    public function insert($designation, $description, $prix, $idType) {
        $r = true;
        $this->insert->execute(array(':designation' => $designation, ':description' => $description, ':prix' => $prix, ':idType' => $idType));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function connect($designation) {
        $unType = $this->connect->execute(array(':designation' => $designation));
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
        return $this->select->fetchAll();
    }

    public function selectById($id) {
        $this->selectById->execute(array(':id' => $id));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    
    public function update($id, $designation, $description, $prix, $idType) {
        $r = true;
        $this->update->execute(array(':designation' => $designation, ':description' => $description, ':prix' => $prix, ':idType' => $idType, ':id' => $id));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }




}


?>