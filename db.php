<?php
function getPDO()
{
    $host = 'localhost';
    $dbname = 'librairie';
    $user = 'root';
    $password = 'root'; 
    try {
        $pdo = new PDO("mysql:host=$host; dbname=$dbname;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        
        throw new Exception('Erreur de connexion à la base de données : ' . $e->getMessage());
    }
}

function livreExiste($auteur, $titre) {
   
    $pdo = getPDO();
    if (!$pdo) return false;

    try {
        
        $sql = "SELECT COUNT(*) FROM livre WHERE auteur = :auteur AND titre = :titre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':auteur' => $auteur, ':titre' => $titre]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    } catch (PDOException $e) {
        throw new Exception('Erreur lors de la vérification de l\'existence du livre : ' . $e->getMessage());
    }
}

function nouveauLivre($auteur, $titre) {
    $pdo = getPDO();
    if (!$pdo) return false;

    try {
       
        $pdo->beginTransaction();
        if (livreExiste($auteur, $titre)) {
            $pdo->rollBack();
            return false;
        }

        $sql = "INSERT INTO livre (auteur, titre) VALUES (:auteur, :titre)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':auteur' => $auteur,
            ':titre' => $titre
        ]);

        $pdo->commit();

        return true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw new Exception('Erreur lors de l\'ajout du nouveau livre : ' . $e->getMessage());
    }
}


function supprimerLivre($titre) {
    $pdo = getPDO();
    if (!$pdo) return false;

    try {
       
        $pdo->beginTransaction();
        $sqlDeleteLivre = "DELETE FROM livre WHERE titre = :titre";
        $stmtDeleteLivre = $pdo->prepare($sqlDeleteLivre);
        $stmtDeleteLivre->execute([':titre' => $titre]);

        $pdo->commit();

        return true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo 'Erreur lors de la suppression du livre : ' . $e->getMessage();
        return false;
    }
}


function rechercherLivre($titre) {
    
    $pdo = getPDO();
    if (!$pdo) return null;

    try {
        
        $sql = "SELECT * FROM livre WHERE titre LIKE :titre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':titre' => "%$titre%"]);

        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;
    } catch (PDOException $e) {
        echo 'Erreur lors de la recherche du livre : ' . $e->getMessage();
        return null;
    }
}
?>
