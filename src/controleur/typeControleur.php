<?php 

function typeControleur($twig, $db){
    $form = array();
    $type = new Type($db);

    if(isset($_POST['btSupprimer'])){
        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        $etat = true;

        foreach ($cocher as $id){

            $exec=$type->delete($id);

            if (!$exec){
                $etat = false;
            } else {
                $etat = true;
            }

        }

        header('Location: index.php?page=type&etat='.$etat);
        exit;
    }

    if(isset($_GET['id'])){
        $exec=$type->delete($_GET['id']);

        if (!$exec){
            $etat = false;
        }else{
            $etat = true;
        }

        header('Location: index.php?page=type&etat='.$etat);
        exit;
    }

    if(isset($_GET['etat'])){
         $form['etat'] = $_GET['etat'];

         if ($form['etat'] == true){
            $form['message'] = "Suppression effectuée";
         } else {
            $form['message'] = "Echec de la suppression";
         }
    }

    $liste = $type->select();
    echo $twig->render('type.html.twig', array('form'=>$form,'liste'=>$liste));
}

function addtypeControleur($twig, $db){
    $form = array();

    if(isset($_POST['btAjouter'])){
        $type = new Type($db);
        $libelle = $_POST['inputDesignation'];
        $exec = $type->insert($libelle);
        if(!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table type';
        }
        else{
            $form['valide'] = true;
            $form['message'] = 'Type ajouté avec succès';
        }
    }

    echo $twig->render('addtype.html.twig', array());
}

function typeModifControleur ($twig, $db){
    $form = array();
    if(isset($_GET['id'])){
        $type = new Type($db);
        $unType = $type->selectById($_GET['id']);
        if ($unType!=null){
            $form['type'] = $unType;
            $type = new Type($db);
            $liste = $type->select();
            $form['types']=$liste;

            if(isset($_POST['btnModifier'])){
                $type = new Type($db);
                $libelle = $_POST['inputLibelle'];
                $id = $_POST['id'];
                $exec=$type->update($id, $libelle);
                if(!$exec){
                    $form['valide'] = false;
                    $form['message'] = 'Echec de la modification';
                }
                else{
                    $form['valide'] = true;
                    $form['message'] = 'Modification réussie';
                }
            }
           
        }
        else{
            $form['message'] = 'Type incorrect';
        }
    }
    
    echo $twig->render('type-modif.html.twig', array('form'=>$form));
}

?>