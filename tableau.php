<?php
session_start();
if (!isset($_SESSION['etudiant'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
<h2>Bienvenue <?= $_SESSION['Prenom'] . " " . $_SESSION['Nom'] ?> (Classe: <?= $_SESSION['Classe'] ?>)</h2>
<a href="livres.php">Voir les livres</a> | 
<a href="deconnexion.php">Déconnexion</a>
</body>
</html>

