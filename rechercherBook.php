<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $resultats = rechercherLivre($titre);
    if ($resultats) {
        foreach ($resultats as $livre) {
            echo "Titre: " . $livre['titre'] . "<br>";
            echo "Auteur: " . $livre['auteur'] . "<br>";
            echo "<hr>";
        }
    } else {
        echo "Aucun résultat trouvé.";
    }
}
?>
