<?php 


function produitControleur($twig, $db)
{
    $form = array();
    $produit = new Produit($db);
    $type = new Type($db);

    foreach ($type->select() as $unType) {
        $form['types'][$unType['id']] = $unType['libelle'];
    }

    if (isset($_POST['btSupprimer'])) {
        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        $etat = true;

        foreach ($cocher as $id) {
            $produitInfo = $produit->selectById($id); // Obtenir les informations du produit
            $exec = $produit->delete($id);

            if (!$exec) {
                $etat = false;
            } else {
                $etat = true;
                // Vérifier si le fichier existe avant de tenter de le supprimer
                if (!empty($produitInfo['photo']) && file_exists('images/' . $produitInfo['photo'])) {
                    unlink('images/' . $produitInfo['photo']);
                }
            }
        }

        header('Location: index.php?page=produit&etat=' . $etat);
        exit;
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $produitInfo = $produit->selectById($id); // Obtenir les informations du produit
        $exec = $produit->delete($id);

        if (!$exec) {
            $etat = false;
        } else {
            $etat = true;
            // Vérifier si le fichier existe avant de tenter de le supprimer
            if (!empty($produitInfo['photo']) && file_exists('images/' . $produitInfo['photo'])) {
                unlink('images/' . $produitInfo['photo']);
            }
        }

        header('Location: index.php?page=produit&etat=' . $etat);
        exit;
    }

    if (isset($_GET['etat'])) {
        $form['etat'] = $_GET['etat'];
    }

    $limite=3;

    if(!isset($_GET['nopage'])){
        $inf=0;
        $nopage=0;
    }
    else{
        $nopage=$_GET['nopage'];
        $inf=$nopage * $limite;
    }

    $r = $produit->selectCount();
    $nb = $r['nb'];
    $liste = $produit->selectLimit($inf,$limite);
    $form['nbpages'] = ceil($nb/$limite);
    $form['nopage'] = $nopage;
    echo $twig->render('produit.html.twig', array('form' => $form, 'liste' => $liste));
}

   

function addproduitControleur($twig, $db){
    $form = array();

    $type = new Type($db);
    $form['types'] = $type->select();

    if(isset($_POST['btAjouter'])){


        $photo = null;
        $produit = new Produit($db);


        $designation = $_POST['inputDesignation'];
        $description = $_POST['inputDescription'];
        $prix = $_POST['inputPrix'];
        $idType = $_POST['inputType'];

        $extensions = array('png', 'gif', 'jpg', 'jpeg');
        $chemin = 'images';
        $taille = 500000;
        $upload = new Upload($extensions, $chemin, $taille);
        $photo = $upload->enregistrer('inputPhoto');

        $exec=$produit->insert($designation, $description, $prix, $photo['nom'], $idType);

        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table produit ';
        } else {
            $form['valide'] = true;
        }
    }
    echo $twig->render('addproduit.html.twig', array('form'=>$form));
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

                $extensions = array('png', 'gif', 'jpg', 'jpeg');
                $chemin = 'images';
                $taille = 500000;
                $upload = new Upload($extensions, $chemin, $taille);
                $photo = $upload->enregistrer('inputPhoto');

                $exec=$produit->update($id, $designation, $description, $prix, $photo['nom'], $idType);

                if(!$exec){
                    $form['valide'] = false;
                    $form['message'] = 'Echec de la modification';
                }
                else{
                    $form['valide'] = true;
                    $form['message'] = 'Modification réussie';

                    $unProduit = $produit->selectById($id);
                    $form['produit'] = $unProduit;
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