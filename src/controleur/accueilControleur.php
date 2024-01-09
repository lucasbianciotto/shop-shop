<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    $form['valide'] = true;
    if ($inputPassword!=$inputPassword2){
    $form['valide'] = false;
    $form['message'] = 'Les mots de passe sont différents';
    }
    else{
    $utilisateur = new Utilisateur($db);
    $idgenere = uniqid();
    $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword, PASSWORD_DEFAULT), 2, $nom, $prenom, $idgenere);
    if (!$exec){
    $form['valide'] = false;
    $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
    }
    }
    $form['email'] = $inputEmail;;


    // Import PhpMailer
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    

    $serveur = $_SERVER['HTTP_HOST']; // Adresse du serveur
    $script = $_SERVER["SCRIPT_NAME"]; // Nom du fichier PHP exécuté
    $email = $inputEmail;
    $message = "
    <html>
    <head>
    </head>
    <body>
    Bienvenue sur Shop-Shop, pour confirmer votre inscription, veuillez cliquer sur le lien
    suivant :
    <a href=\"http://$serveur$script?page=validation&email=$email&idgenere=$idgenere\">Valider
    votre inscription</a>
    </body>
    </html>";
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=utf-8';
    $headers[] = 'From: Shop-Shop < audiohaven@gmail.com >';
    
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = '127.0.0.1';
    $mail->Port = 1025;
    $mail->SMTPAuth = false;
    $mail->SMTPSecure = false;
    $mail->setFrom('contact@audiohaven.com', 'AudioHaven');
    $mail->addAddress($email);
    $mail->Subject = 'Inscription sur AudioHaven';
    $mail->Body = $message;
    $mail->isHTML(true);
    $mail->send();

    }
    echo $twig->render('inscrire.html.twig', array('form'=>$form));
   }

   function validationControleur($twig, $db){
    $form = array();
    if(isset($_GET['email']) && isset($_GET['idgenere'])){
    $utilisateur = new Utilisateur($db);
    $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
    if($unUtilisateur!=null){
    if($unUtilisateur['idgenere']==$_GET['idgenere']){
    $form['valide'] = true;
    $form['email'] = $_GET['email'];
    $form['message'] = 'Utilisateur correct';
    $exec=$utilisateur->updateValide($unUtilisateur['id']);
    if(!$exec){
    $form['valide'] = false;
    $form['message'] = 'Erreur lors de la validation du compte';
    } else {
        header("Location:index.php");
    }
    }
    else{
    $form['valide'] = false;
    $form['message'] = 'Utilisateur incorrect';
    }
    }
    else{
    $form['valide'] = false;
    $form['message'] = 'Utilisateur incorrect';
    }
    }
    else{
    $form['valide'] = false;
    $form['message'] = 'Utilisateur incorrect';
    }
    echo $twig->render('validation.html.twig', array('form'=>$form));
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

    if ($unUtilisateur['valider']==1){

        $_SESSION['login'] = $inputEmail;
        $_SESSION['role'] = $unUtilisateur['idRole']; 
        
        header("Location:index.php");
    } else {
        $form['valide'] = false;
        $form['message'] = 'Compte non validé, vous avez reçu un mail de confirmation';
    
    }

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

       function panierControleur($twig,$db){
            $form = array();
            $liste = array();

            if(isset($_POST['placerCommade'])){
                $montant = $_POST['montant'];
                $aujourdhui = new DateTime();
                $aujourdhui->setTimezone(new DateTimeZone('Europe/Paris'));
                $date = $aujourdhui->format("Y-m-d H:i:s");
                $etat = 1;
                $utilisateur = new Utilisateur($db);
                $unUtil = $utilisateur->selectByEmail($_SESSION['login']);
                $idUtilisateur = $unUtil['id'];
                $form['valide'] = true;
                $commande = new Commande($db);
                $exec=$commande->insert($montant,$date,$etat,$idUtilisateur);
                if(!$exec){
                $form['valide'] = false;
                $form['message'] = 'Problème de l\'enregistremet de la commande';
                }else{
                $maCommande = $commande->selectByDateCli($date,$idUtilisateur);
                $composer = new Composer($db);
                foreach ($_SESSION['panier'] as $k => $v) {
                $execC = $composer->insert($maCommande['id'],$k,$v);
                if(!$execC){
                $form['erreur'] = 'Problème : au moins un produit n\'a pas été validé';
                }
                }
                $form['message'] = 'Votre commande a été passée';
                unset($_SESSION['panier']);
                }
               }else{
    
                    if (!empty($_SESSION['panier'])) {
                        $ids = array_keys($_SESSION['panier']);
                        $produits = new Produit($db);
                        $liste = $produits->selectIn($ids);
                    }

                    if(isset($_GET['remove'])){
                        unset($_SESSION['panier'][$_GET['remove']]);
                    }
                    
                    if (isset($_POST['update'])) {
                        foreach ($_POST as $k => $v) {
                            if(strpos($k,'q-')!== false){
                                $explose = explode('-',$k);
                                $unid = (int)$explose[1];
                                $_SESSION['panier'][$unid] = $v;
                            }
                        }
                        header("Location:index.php?page=panier");
                    }
                }

            echo $twig->render('panier.html.twig', array('form'=>$form,'liste'=>$liste));
       }


    




           
?>