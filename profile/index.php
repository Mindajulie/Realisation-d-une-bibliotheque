<?php
require "../includes/auth.php";
require "../includes/config.php";

$id = $_SESSION["user_id"];


$stmt = $pdo->prepare("SELECT nom, prenom, email FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom    = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $email  = trim($_POST["email"]);
    $password = $_POST["password"] ?? "";

    
    if ($nom === "" || $prenom === "") {
        $errors[] = "Nom et prénom obligatoires";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide";
    }

    
    $check = $pdo->prepare("
        SELECT id FROM users 
        WHERE email = ? AND id != ?
    ");
    $check->execute([$email, $id]);

    if ($check->fetch()) {
        $errors[] = "Email déjà utilisé";
    }

    
    if (empty($errors)) {

        if ($password !== "") {

            if (strlen($password) < 8) {
                $errors[] = "Mot de passe trop court (8 caractères)";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $pdo->prepare("
                    UPDATE users 
                    SET nom = ?, prenom = ?, email = ?, password = ?
                    WHERE id = ?
                ")->execute([$nom, $prenom, $email, $hash, $id]);
            }

        } else {
            $pdo->prepare("
                UPDATE users 
                SET nom = ?, prenom = ?, email = ?
                WHERE id = ?
            ")->execute([$nom, $prenom, $email, $id]);
        }

        $_SESSION["nom"] = $nom;
        $_SESSION["prenom"] = $prenom;

        $success = true;
    }
}
?>

<?php include "../includes/head.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-5">
    <h3 class="mb-4">👤 Mon profil</h3>

    <div class="card p-4 col-md-6 mx-auto">

        <form method="POST">

            <input class="form-control mb-3" name="nom" placeholder="Nom"
                   value="<?= htmlspecialchars($user["nom"]) ?>" required>

            <input class="form-control mb-3" name="prenom" placeholder="Prenom"
                   value="<?= htmlspecialchars($user["prenom"]) ?>" required>

            <input class="form-control mb-3" name="email" placeholder="Email"
                   value="<?= htmlspecialchars($user["email"]) ?>" required>

            <input class="form-control mb-3" name="password"
                   type="password"
                   placeholder="Nouveau mot de passe (optionnel)">
            <small class="text-muted">
                Laisser vide pour conserver le mot de passe actuel
            </small>

            <button class="btn btn-futur w-100 mt-3">
                Enregistrer
            </button>
        </form>

    </div>
</div>

<?php include "../includes/footer.php"; ?>

<?php if ($success): ?>
<script>
showToast("Profil mis à jour avec succès", "success");
</script>
<?php endif; ?>

<?php if ($errors): ?>
<script>
<?php foreach ($errors as $e): ?>
showToast("<?= addslashes($e) ?>", "danger");
<?php endforeach; ?>
</script>
<?php endif; ?>
