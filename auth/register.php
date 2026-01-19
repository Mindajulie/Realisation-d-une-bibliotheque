<?php
require "../includes/config.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom     = trim($_POST["nom"] ?? "");
    $prenom  = trim($_POST["prenom"] ?? "");
    $email   = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

   

    if ($nom === "" || $prenom === "") {
        $errors[] = "Nom et prénom obligatoires";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide";
    }

    if (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
    }

    
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->fetch()) {
        $errors[] = "Cet email est déjà utilisé";
    }

   
    if (empty($errors)) {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO users (nom, prenom, email, password, role)
            VALUES (?, ?, ?, ?, 'user')
        ");
        $stmt->execute([$nom, $prenom, $email, $hash]);

        header("Location: login.php?success=1");
        exit;
    }
}
?>

<?php include "../includes/head.php"; ?>

<div class="auth-page">
    <div class="auth-card">
        <h3>📝 Inscription</h3>

        <form method="POST">

            <div class="mb-3">
                <input type="text" name="nom" class="form-control"
                       placeholder="Nom" required value="<?= htmlspecialchars($nom ?? "") ?>">
            </div>

            <div class="mb-3">
                <input type="text" name="prenom" class="form-control"
                       placeholder="Prénom" required value="<?= htmlspecialchars($prenom ?? "") ?>">
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control"
                       placeholder="Email" required value="<?= htmlspecialchars($email ?? "") ?>">
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control"
                       placeholder="Mot de passe" required>
                <small class="text-muted">Minimum 8 caractères</small>
            </div>

            <button class="btn btn-futur w-100">Créer le compte</button>

            <p class="mt-3 text-center">
                Déjà un compte ?
                <a href="login.php">Connexion</a>
            </p>
        </form>
    </div>
</div>



<?php if (!empty($errors)): ?>
<script>
<?php foreach ($errors as $e): ?>
    showToast("<?= addslashes($e) ?>", "danger");
<?php endforeach; ?>
</script>
<?php endif; ?>
