<?php

class Commande {

    private $db;
    private $insert;
    private $selectByDateCli;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $this->db->prepare("insert into commande(montant,date,etat,idUtilisateur) values (:montant,:date,:etat,:idUtilisateur)");
        $this->selectByDateCli = $this->db->prepare("select * from commande where date=:date and idUtilisateur=:idUtilisateur");
    }

    public function insert($montant, $date, $etat, $idUtilisateur) {
        $r = true;
        $this->insert->execute(array(':montant' => $montant, ':date' => $date, ':etat' => $etat, ':idUtilisateur' => $idUtilisateur));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }


    public function selectByDateCli($date,$idUtilisateur) {
        $this->selectByDateCli->execute(array(':date' => $date, ':idUtilisateur' => $idUtilisateur));
        if ($this->selectByDateCli->errorCode() != 0) {
            print_r($this->selectByDateCli->errorInfo());
        }
        return $this->selectByDateCli->fetch();
    }

    


}




?>