<?php
/* initialisation des fichiers TWIG */
require_once '../lib/vendor/autoload.php';
require_once '../config/parametres.php';
require_once '../config/connexion.php';
require_once '../src/controleur/_controleurs.php';
require_once '../src/modele/_classes.php';
require_once '../config/routes.php';
session_start();
$loader = new \Twig\Loader\FilesystemLoader('../src/vue/');
$twig = $twig = new \Twig\Environment($loader, []);
$twig->addGlobal('session', $_SESSION);
$db = connect($config);
$contenu = getPage($db);
// Exécution de la fonction souhaitée
$contenu($twig,$db);
?>