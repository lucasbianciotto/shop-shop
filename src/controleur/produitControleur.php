<?php 


function produitControleur($twig, $db){
    $form = array();
    $produit = new Produit($db);
    $liste = $produit->select();
    echo $twig->render('produit.html.twig', array('form'=>$form,'liste'=>$liste));
}

function addproduitControleur($twig, $db){
    $form = array();

    if(isset($_POST['btAjouter'])){
        $produit = new Produit($db);
        $designation = $_POST['inputDesignation'];
        $description = $_POST['inputDescription'];
        $prix = $_POST['inputPrix'];
        $idType = $_POST['idType'];

        $upload = new Upload(array('png','gif','jpg','jpeg'), 'img/produit', 500000);
        $photo = $upload->enregistrer('photo');

        $exec = $produit->insert($designation, $description, $prix, $idType, $photo['nom']);
        if(!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table produit';
        }
        else{
            $form['valide'] = true;
            $form['message'] = 'Produit ajouté avec succès';
        }
    }

    echo $twig->render('addproduit.html.twig', array());
}

function produitModifControleur($twig, $db){
    $form = array();
    if(isset($_GET['id'])){
        $produit = new Produit($db);
        $unProduit = $produit->selectById($_GET['id']);
        if ($unProduit!=null){
            $form['produit'] = $unProduit;
            $type = new Type($db);
            $liste = $type->select();
            $form['types']=$liste;

            if(isset($_POST['btnModifier'])){
                $produit = new Produit($db);
                $designation = $_POST['inputDesignation'];
                $description = $_POST['inputDescription'];
                $prix = $_POST['inputPrix'];
                $idType = $_POST['idType'];
                $id = $_POST['id'];
                $exec=$produit->update($id, $designation, $description, $prix, $idType);
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
            $form['message'] = 'Produit incorrect';
        }
    }
    
    echo $twig->render('produit-modif.html.twig', array('form'=>$form));
}

?>