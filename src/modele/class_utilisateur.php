<?php
class Utilisateur{
 private $db;
 private $insert;
 private $select;
 private $connect;
 private $update;
 private $delete;
 private $selectById;
 private $selectByEmail;

 public function __construct($db){
 $this->db = $db;
 $this->insert = $this->db->prepare("insert into utilisateur(email, mdp, nom, prenom, idRole, idgenere) values (:email, :mdp, :nom, :prenom, :role, :idgenere)");
 $this->connect = $this->db->prepare("select email, idRole, mdp, valider from utilisateur where
email=:email");
$this->select = $db->prepare("select u.id, email, idRole, nom, prenom, r.libelle as libellerole from utilisateur u, role r where u.idRole = r.id order by nom");
$this->selectById = $db->prepare("select id, email, nom, prenom, idRole, valider from utilisateur where id=:id");
$this->update = $db->prepare("update utilisateur set nom=:nom, prenom=:prenom, email=:email 
where id=:id");
$this->delete = $db->prepare("delete from utilisateur where id=:id");
$this->selectByEmail = $db->prepare("select id, email, nom, prenom, idRole from utilisateur where email=:email");
 }
 public function insert($email, $mdp, $role, $nom, $prenom, $idgenere){
 $r = true;
 $this->insert->execute(array(':email'=>$email, ':mdp'=>$mdp, ':role'=>$role, ':nom'=>$nom, ':prenom'=>$prenom, ':idgenere'=>$idgenere));
 if ($this->insert->errorCode()!=0){ print_r($this->insert->errorInfo());
 $r=false;
 }
 return $r;
}
 public function connect($email){
 $unUtilisateur = $this->connect->execute(array(':email'=>$email));
 if ($this->connect->errorCode()!=0){
 print_r($this->connect->errorInfo());
 }
 return $this->connect->fetch();
 }

 public function select(){
    $this->select->execute();
    if ($this->select->errorCode()!=0){
    print_r($this->select->errorInfo());
    }
    return $this->select->fetchAll();
    }

    public function selectById($id){
        $this->selectById->execute(array(':id'=>$id)); if ($this->selectById->errorCode()!=0){
        print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
        }

        public function update($id, $email, $nom, $prenom){
            $r = true;
            $this->update->execute(array(':id'=>$id, ':email'=>$email, ':nom'=>$nom, ':prenom'=>$prenom));
            if ($this->update->errorCode()!=0){ print_r($this->update->errorInfo());
            $r=false;
            }
            return $r;
           }

           public function delete($id){
            $r = true;
            $this->delete->execute(array(':id'=>$id));
            if ($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
            $r=false;
            }
            return $r;
            }

            public function selectByEmail($email){
                $this->selectByEmail->execute(array(':email'=>$email)); if
                ($this->selectByEmail->errorCode()!=0){
                print_r($this->selectByEmail->errorInfo());
                }
                return $this->selectByEmail->fetch();
                }
           


}
?>