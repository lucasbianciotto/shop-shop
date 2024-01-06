
<?php

class Type {

    private $db;
    private $insert;
    private $select;
    private $connect;
    private $selectById;
    private $delete;
    private $update;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $this->db->prepare("insert into type(libelle) values (:libelle)");
        $this->connect = $this->db->prepare("select libelle from type where libelle=:libelle");
        $this->select = $db->prepare("select id, libelle from type order by libelle");
        $this->selectById = $db->prepare("select id, libelle from type where id=:id");
        $this->update = $db->prepare("update type set libelle=:libelle where id=:id");
        $this->delete = $db->prepare("delete from type where id=:id");
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
        $unType = $this->connect->execute(array(':libelle' => $libelle));
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

    public function delete($id) {
        $r = true;
        $this->delete->execute(array(':id' => $id));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function update($id, $libelle){
        $r = true;
        $this->update->execute(array(':libelle'=>$libelle, ':id'=>$id));
        if ($this->update->errorCode()!=0){ print_r($this->update->errorInfo());
        $r=false;
        }
        return $r;
       }




}


?>