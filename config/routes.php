<?php
function getPage($db){
    $lesPages['accueil'] = "accueilControleur;0";
    $lesPages['contact'] = "contactControleur;0";
    $lesPages['apropos'] = "aproposControleur;0";
    $lesPages['inscrire'] = "inscrireControleur;0";
    $lesPages['connexion'] = "connexionControleur;0";
    $lesPages['deconnexion'] = "deconnexionControleur;0";
    $lesPages['maintenance'] = "maintenanceControler;0";
    $lesPages['mentionslegales'] = "mentionslegalesControleur;0";
    $lesPages['recherche'] = "rechercheControleur;0";
    $lesPages['utilisateur'] = "utilisateurControleur;1";
    $lesPages['utilisateurModif'] = "utilisateurModifControleur;1";
    $lesPages['type'] = "typeControleur;1";
    $lesPages['addtype'] = "addtypeControleur;1";
    $lesPages['typemodif'] = "typeModifControleur;1";
    $lesPages['produit'] = "produitControleur;1";
    $lesPages['addproduit'] = "addproduitControleur;1";
    $lesPages['modifproduit'] = "produitModifControleur;1";
    $lesPages['produitfiche'] = "produitficheControleur;0";
    $lesPages['panier'] = "panierControleur;0";
    
    if ($db!=null){
        if (isset($_GET['page'])){
            $page = $_GET['page'];
        }else{
            $page = 'accueil';
        }
        if (!isset($lesPages[$page])){
            $page = 'accueil';
        }
       
        $explose = explode(";",$lesPages[$page]);

        $role = $explose[1];
        if ($role != 0){
            if(isset($_SESSION['login'])){
                if(isset($_SESSION['role'])){
                    if($role!=$_SESSION['role']){
                        $contenu = 'accueilControleur';
                    }else{
                        $contenu = $explose[0];
                    }
                }else{
                    $contenu = 'accueilControleur';;
                }
            }else{
                $contenu = 'accueilControleur';;
            }
        }else{
            $contenu = $explose[0];
        }

    }else{
        $contenu = $lesPages['maintenance'];
    }

    return $contenu;
    }
?>