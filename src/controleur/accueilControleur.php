<?php
function accueilControleur($twig){
    echo $twig->render('accueil.html.twig', array());
//  echo 'Page d\'accueil du site';
}

function contactControleur($twig){
    echo $twig->render('accueil.html.twig', array());
//  echo 'Contact';
}

function mentionslegalesControleur($twig){
    echo $twig->render('accueil.html.twig', array());
    // echo 'Mentions Légales';
   }

function aproposControleur($twig){
    echo $twig->render('accueil.html.twig', array());
    // echo 'A propos';
   }

   function maintenanceControler($twig) {
        echo $twig->render('maintenance.html.twig', array());
   }

   function inscrireControleur($twig, $db){
    $form = array();
    if (isset($_POST['btInscrire'])){
    $inputEmail = $_POST['inputEmail'];
    $inputPassword = $_POST['inputPassword'];
    $inputPassword2 =$_POST['inputPassword2'];
    $nom = $_POST['inputNom'];
    $prenom =$_POST['inputPrenom'];
    $role = $_POST['role'];
    $form['valide'] = true;
    if ($inputPassword!=$inputPassword2){
    $form['valide'] = false;
    $form['message'] = 'Les mots de passe sont différents';
    }
    else{
    $utilisateur = new Utilisateur($db);
    $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword, PASSWORD_DEFAULT), $role, $nom, $prenom);
    if (!$exec){
    $form['valide'] = false;
    $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
    }
    }
    $form['email'] = $inputEmail;
    $form['role'] = $role;
    }
    echo $twig->render('inscrire.html.twig', array('form'=>$form));
   }

   function connexionControleur($twig, $db){
    $form = array();
   
    if (isset($_POST['btConnecter'])){
    $form['valide'] = true;
    $inputEmail = $_POST['inputEmail'];
    $inputPassword = $_POST['inputPassword'];
    $utilisateur = new Utilisateur($db);
    $unUtilisateur = $utilisateur->connect($inputEmail);
    if ($unUtilisateur!=null){
    if(!password_verify($inputPassword,$unUtilisateur['mdp'])){
    $form['valide'] = false;
    $form['message'] = 'Login ou mot de passe incorrect';
    }
    else{
    $_SESSION['login'] = $inputEmail;
    $_SESSION['role'] = $unUtilisateur['idRole']; header("Location:index.php");
    }
    }
    else{
    $form['valide'] = false;
    $form['message'] = 'Login ou mot de passe incorrect';
    }
    }
    echo $twig->render('connexion.html.twig', array('form'=>$form));
   }

   function deconnexionControleur($twig, $db){
    session_unset();
    session_destroy();
    header("Location:index.php");
    }

    function rechercheControleur($twig, $db){
        $form = array();
        $liste = array();

        if (isset($_GET['search'])){
            $form['valide'] = true;
            $recherche = $_GET['search'];
            $form['search'] = $recherche;
            $produit = new Produit($db);
            $exec = $produit->recherche($recherche);
            if ($exec){

                $limite = 3;

                // Gestion de la pagination en fonction des résultats de recherche
                $page = isset($_GET['nopage']) ? intval($_GET['nopage']) : 0;
                $inf = $page * $limite;

                $form['produit'] = $exec;

                // Utilisation des résultats de recherche pour la pagination
                $nb = count($exec);
                $form['nbpages'] = ceil($nb / $limite);
                $form['nopage'] = $page;

                // Sélection des résultats de recherche paginés
                $liste = array_slice($exec, $inf, $limite);
            } else{
                $form['valide'] = false;
                $form['message'] = 'Problème de recherche ';
            }
        }

        
        echo $twig->render('recherche.html.twig', array('form'=>$form , 'liste'=>$liste));
       }


    




           
?>