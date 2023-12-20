<?php
function getPage($db){
    $lesPages['accueil'] = "accueilControleur";
    $lesPages['contact'] = "contactControleur";
    $lesPages['apropos'] = "aproposControleur";
    $lesPages['inscrire'] = "inscrireControleur";
    $lesPages['connexion'] = "connexionControleur";
    $lesPages['deconnexion'] = "deconnexionControleur";
    $lesPages['utilisateur'] = "utilisateurControleur";
    $lesPages['utilisateurModif'] = "utilisateurModifControleur";
    $lesPages['mentionslegales'] = "mentionslegalesControleur";
    $lesPages['maintenance'] = "maintenanceControler";
    $lesPages['type'] = "typeControleur";
    $lesPages['addtype'] = "addtypeControleur";
    $lesPages['produit'] = "produitControleur";
    $lesPages['addproduit'] = "addproduitControleur";
    $lesPages['modifproduit'] = "produitModifControleur";
    
    if ($db!=null){
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        } else{
            $page = 'accueil';
        }
        if (!isset($lesPages[$page])){
            $page = 'accueil';
        }
            $contenu = $lesPages[$page];
        }
        else{
            $contenu = $lesPages['maintenance'];
        }
        // La fonction envoie le contenu
        return $contenu;
        }
?>