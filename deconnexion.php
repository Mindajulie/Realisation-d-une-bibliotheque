<?php
session_start();        // On démarre la session
session_unset();        // On supprime toutes les variables de session
session_destroy();      // On détruit la session

// Redirection vers la page de connexion
header("Location: index.php");
exit();
?>
