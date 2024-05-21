<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    supprimerLivre($titre);
    echo "Livre supprimé avec succès!";
}
?>