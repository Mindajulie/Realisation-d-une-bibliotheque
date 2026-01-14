<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO students(codeEtudiant, nom, prenom, adresse, classe, password) 
                            VALUES(?,?,?,?,?,?)");
    $stmt->execute([
        $_POST['codeEtudiant'],
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['adresse'],
        $_POST['classe'],
        password_hash($_POST['password'], PASSWORD_DEFAULT)
    ]);
    $success = "Inscription réussie ! Vous pouvez vous connecter.";
}
?>
<!DOCTYPE html>
<html>
<head><title>Inscription</title></head>
<body>
<h2>Inscription Étudiant</h2>
<form method="POST">
  Code Étudiant: <input type="text" name="codeEtudiant"><br>
  Nom: <input type="text" name="nom"><br>
  Prénom: <input type="text" name="prenom"><br>
  Adresse: <input type="text" name="adresse"><br>
  Classe: <input type="text" name="classe"><br>
  Mot de passe: <input type="password" name="password"><br>
  <button type="submit">S’inscrire</button>
</form>
<?php if(isset($success)) echo "<p style='color:green'>$success</p>"; ?>
</body>
</html>
