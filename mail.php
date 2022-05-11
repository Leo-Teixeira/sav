<?php
require 'sendMail.php';
require 'insertionSql.php';

/* Déclaration des différentes variables */
$emmeteur = htmlspecialchars($_POST['email']);
$demande = htmlspecialchars($_POST['sujet_demande']);
$sujet = "demande d'intervention du SAV";
$destinataire = 'remope1717@awinceo.com';
$nameFile = $_FILES['parcours_fichier']['name'];
$sizeFile = $_FILES['parcours_fichier']['size'];
$tmp_name = $_FILES['parcours_fichier']['tmp_name'];
$typeFile = $_FILES['parcours_fichier']['type'];

/*if (preg_match('#[0-9]{6}$#', $_POST['code']))
{
    $code = $_POST['code'];
}
else
{
    echo '<h1>Le code saisie est incorrect</h1>';
}*/

/* si $_FILES et >0 cela veut dire que le fichier n'a pas été télécharger ou qu'il n'y en a pas donc on effectue un envoie sans piece jointe */
if ($_FILES['parcours_fichier']['name'][0] == '')
{
    sendmail($emmeteur, $sujet, $demande, $destinataire);
    //header('Location: main.php');
}

/* sinon le fichier est bien télécharger donc envoie avec piece jointe*/
else if ($_FILES['parcours_fichier']['name'][0] != '')
{
    sendmailPJ($emmeteur, $sujet, $demande, $destinataire, $nameFile, $sizeFile, $typeFile, $tmp_name);
    //header('Location: main.php');
}

for ($cpt=0; $cpt<count($_FILES['parcours_fichier']['name']); $cpt++)
{
    if ($_FILES['parcours_fichier']['error'][$cpt] > 0)
    {
        echo '<h1>Le fichier que vous voulz envoyé ne peut pas être télécharger</h1>';
    }
}

createSection($code, $emmeteur, $sujet, $demande, $server, $tmp_name, $nameFile, $sizeFile);
?>