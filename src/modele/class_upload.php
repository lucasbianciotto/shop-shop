<?php
class Upload{
private $extensions; private $chemin; private $taille;
/*
$extensions array comprenant toutes les extensions
$chemin vers le répertoire de stockage des fichiers
$taille taille max du fichier en ko retourne le nom de la photo ou null
*/
public function construct($extensions, $chemin, $taille){
$this->extensions = $extensions;
$this->chemin = $chemin;
$this->taille = $taille;
}
public function enregistrer($data){
$fichier =array();
$fichier['nom'] = null;
$fichier['erreur'] = null;
$msg = null;
if(isset($_FILES[$data])){
if(!empty($_FILES[$data]['name'])){
if( !in_array( substr(strrchr($_FILES[$data]['name'], '.'), 1), $this->extensions)
){
$msg = 'Veuillez sélectionner un fichier de type : ';
foreach($this->extensions as $uneExtension){
$msg .= $uneExtension.' ';
}
}else{
if( file_exists($_FILES[$data]['tmp_name'])&&
(filesize($_FILES[$data]['tmp_name'])) > $this->taille){
echo 'Votre fichier doit faire moins de '.$this->taille.'Ko !';
}else{
$fichier['nom'] = basename($_FILES[$data]['name']);
// enlever les accents
$fichier['nom']=strtr($fichier['nom'],'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèé
êëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
// remplacer les caractères autres que lettres, chiffres et point par _
$fichier['nom'] = preg_replace('/([^.a-z0-9]+)/i', '_', $fichier['nom']);
// copie du fichier
move_uploaded_file($_FILES[$data]['tmp_name'], $this->chemin.'/'.$fi-
chier['nom']);
}
}
}
}
$fichier['erreur'] = $msg; return $fichier;
}
}
?>