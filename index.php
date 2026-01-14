<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CodeEtudiant = $_POST['CodeEtudiant'];
    $Nom = $_POST['Nom'];

    $stmt = $conn->prepare("SELECT * FROM etudiant WHERE CodeEtudiant = ?");
    $stmt->execute([$code]);
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($etudiant && password_verify($pass, $etudiant['password'])) {
        $_SESSION['etudiant'] = $etudiant['codeEtudiant'];
        $_SESSION['Nom'] = $etudiant['Nom'];
        $_SESSION['Prenom'] = $etudiant['Prenom'];
        $_SESSION['Adresse'] = $etudiant['Adresse'];
        $_SESSION['Classe'] = $etudiant['Classe'];
        header("Location: tableau.php");
        exit();
    } else {
        $error = "Code étudiant ou mot de passe incorrect";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Connexion</title></head>
<body>
<h2>Connexion Étudiant</h2>
<form method="POST">
    <label for="">CodeEtudiant</label>
  <input type="text" name="codeEtudiant"><br>

    <label for="">Nom</label>
  <input type="text" name="Nom"><br>

    <label for="">Prenom</label>
   <input type="text" name="Prenom"><br>

    <label for="">Adesse</label>
  <input type="text" name="Adresse"><br>

    <label for="">Classe</label>
  <input type="text" name="Classe"><br>
  <button type="submit">Se connecter</button>
</form>
<a href="register.php">Créer un compte</a>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
</body>
</html>
