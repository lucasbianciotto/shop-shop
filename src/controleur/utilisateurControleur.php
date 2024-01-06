<?php

function utilisateurControleur($twig, $db){
    $form = array();
    $utilisateur = new Utilisateur($db);

    if(isset($_POST['btSupprimer'])){
        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        $etat = true;
        foreach ( $cocher as $id){
            $exec=$utilisateur->delete($id);
            if (!$exec){
                $etat = false;
            }
        }
        header('Location: index.php?page=utilisateur&etat='.$etat);
        exit;
    }

    if(isset($_GET['id'])){
        $exec=$utilisateur->delete($_GET['id']);
        if (!$exec){
            $etat = false;
        }else{
            $etat = true;
        }

        header('Location: index.php?page=utilisateur&etat='.$etat); exit;
    }

    if(isset($_GET['etat'])){
        $form['etat'] = $_GET['etat'];
    }
    
    $liste = $utilisateur->select();
    echo $twig->render('utilisateur.html.twig', array('form'=>$form,'liste'=>$liste));
    }

function utilisateurModifControleur($twig, $db){
    $form = array(); if(isset($_GET['id'])){
    $utilisateur = new Utilisateur($db);
    $unUtilisateur = $utilisateur->selectById($_GET['id']); if ($unUtilisateur!=null){
    $form['utilisateur'] = $unUtilisateur;
    $role = new Role($db);
    $liste = $role->select();
    $form['roles']=$liste;
    }
    else{
    $form['message'] = 'Utilisateur incorrect';
    }
    }
    else{
    if(isset($_POST['btModifier'])){
    $utilisateur = new Utilisateur($db);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['inputEmail'];
    $id = $_POST['id'];
    $exec=$utilisateur->update($id, $email, $nom, $prenom);
    if(!$exec){
    $form['valide'] = false; 
    $form['message'] = 'Echec de la modification';
    }else{
    $form['valide'] = true; 
    $form['message'] = 'Modification réussie'; 
    }
    }else{
    $form['message'] = 'Utilisateur non précisé';
    }
    }
    echo $twig->render('utilisateur-modif.html.twig', array('form'=>$form));

   }


?>