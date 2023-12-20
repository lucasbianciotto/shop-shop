<?php 
// Implemente la fonction de suprimer   
function typeControleur($twig, $db){
    $form = array();
    $type = new Type($db);
    if(isset($_POST['btSupprimer'])){
    $cocher = $_POST['cocher'];
    $form['valide'] = true;
    $etat = true;
    foreach ( $cocher as $id){
    $exec=$type->delete($id);
    if (!$exec){
    $etat = false;
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
    header('Location: index.php?page=type&etat='.$etat); exit;
    }
    if(isset($_GET['etat'])){
    $form['etat'] = $_GET['etat'];
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

?>