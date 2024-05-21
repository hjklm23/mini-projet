<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auteur = $_POST['auteur'];
    $titre= $_POST['titre'];

    $result = nouveauLivre($auteur, $titre);

    if ($result) {
        echo "Nouveau livre ajouté avec succès!";
    } else {
        echo "Erreur lors de l'ajout du nouveau livre.";
    }
}
?>
