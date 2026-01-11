<?php
$base_url = "/keep-my-pet/";
$base_dir = __DIR__ . "/../../";

// Boot
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Require DB & model
include_once $base_dir . 'app/Models/connection_db.php';
include_once $base_dir . 'app/Models/requests.users.php';
include_once $base_dir . 'app/Controller/ProfileController.php';

// Handle POST and load user
$result = ProfileController::handle($db, $base_dir, $base_url);
$user = $result['user'] ?? null;

// CSRF token
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

// If saved flag present, show toast via JS
$saved = !empty($_GET['saved']);

// HEADER
include $base_dir . "/app/Views/Components/header.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Paramètres - Compte</title>
  <link rel="stylesheet" href="<?php echo $base_url; ?>/public/assets/css/profile_settings.css">
</head>

<body>

  <main class="settings-page">
    <aside class="settings-sidebar">
      <div class="logo-small">KeepMyPet</div>
      <nav>
        <ul>
          <li class="active" data-tab="compte"><span class="icon">👤</span> Compte</li>
          <li data-tab="securite"><span class="icon">🔒</span> Sécurité</li>
          <li data-tab="historique"><span class="icon">🕘</span> Historique</li>
          <li data-tab="preferences"><span class="icon">⚙️</span> Préférences</li>
        </ul>
      </nav>
    </aside>

    <section class="settings-main">
      <section id="compte">
        <h2>Compte</h2>
        <p class="lead">Gérer les informations de votre compte.</p>

        <?php if (!empty($result['errors'])): ?>
          <div class="settings-card" style="background:#ffdddd;color:#5a0000;margin-bottom:16px;padding:14px;border-radius:12px">
            <strong>Erreurs :</strong>
            <ul>
              <?php foreach ($result['errors'] as $err): ?>
                <li><?php echo htmlspecialchars($err); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <div class="settings-card">
          <form id="accountForm" method="post" action="<?php echo $base_url; ?>/app/Views/profile_settings.php">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

            <div class="two-col">
              <div class="col">
                <label>Mail</label>
                <input type="email" name="email" placeholder="votre@email.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ($user['email'] ?? '')); ?>">

                <label>Nom</label>
                <input type="text" name="last_name" placeholder="Dupont" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ($user['last_name'] ?? '')); ?>">

                <label>Prénom</label>
                <input type="text" name="first_name" placeholder="Jean" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ($user['first_name'] ?? '')); ?>">

                <label>Téléphone</label>
                <input type="text" name="phone_number" placeholder="06 12 34 56 78" value="<?php echo htmlspecialchars($_POST['phone_number'] ?? ($user['phone_number'] ?? '')); ?>">
              </div>

              <div class="col">
                <label>Adresse</label>
                <input type="text" name="address" placeholder="10 rue de Rivoli" value="<?php echo htmlspecialchars($_POST['address'] ?? ($user['address'] ?? '')); ?>">

                <label>Code postal</label>
                <input type="text" name="postal_code" placeholder="75001" value="<?php echo htmlspecialchars($_POST['postal_code'] ?? ($user['postal_code'] ?? '')); ?>">
              </div>
            </div>

            <div class="form-actions">
              <button type="submit" id="saveBtn" class="btn primary">Enregistrer</button>
            </div>
          </form>
        </div>
      </section>

      <section class="hidden" id="securite">
        <h3>Sécurité</h3>
        <p>Gérer le mot de passe et la session.</p>
        <div class="settings-card">
          <form id="passwordForm" method="post" action="<?php echo $base_url; ?>/app/Views/profile_settings.php">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <input type="hidden" name="action" value="change_password">

            <label>Mot de passe actuel</label>
            <input type="password" name="current_password" placeholder="Mot de passe actuel" required>

            <label>Nouveau mot de passe</label>
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>

            <label>Confirmer le mot de passe</label>
            <input type="password" name="new_password_confirm" placeholder="Confirmer le mot de passe" required>

            <div class="form-actions"><button type="submit" id="passwordSaveBtn" class="btn primary">Mettre à jour</button></div>
          </form>
        </div>
      </section>

      <section class="hidden" id="historique">
        <h3>Historique</h3>
        <p>Récents changements et actions.</p>
        <div class="settings-card">
          <p>Pas encore d'activité.</p>
        </div>
      </section>

      <section class="hidden" id="preferences">
        <h3>Préférences</h3>
        <div class="settings-card">
          <label>Langue</label>
          <select>
            <option>FR</option>
            <option>EN</option>
          </select>
          <label>Thème</label>
          <select>
            <option>Light</option>
            <option>Dark</option>
          </select>
          <div class="form-actions"><button class="btn">Enregistrer</button></div>
        </div>
      </section>

    </section>

  </main>

  <div id="toast" class="toast" aria-hidden="true"><?php echo $saved ? 'Modifications enregistrées' : 'Enregistré'; ?></div>

  <script>
    var PROFILE_SAVED = <?php echo $saved ? 'true' : 'false'; ?>;
  </script>
  <script src="<?php echo $base_url; ?>/public/assets/js/profile_settings.js"></script>

  <?php include $base_dir . '/app/Views/Components/footer.php'; ?>
</body>

</html>