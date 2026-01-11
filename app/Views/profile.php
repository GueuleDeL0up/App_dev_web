<?php
// Define the base
$base_url = "/keep-my-pet/";  // For HTML links
$base_dir = __DIR__ . "/../../";  // For PHP includes

// Start session and require authentication
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (empty($_SESSION['user_id'])) {
  header('Location: ' . $base_url . '/app/Views/log_in.php');
  exit;
}

// DB and user model
include $base_dir . 'app/Models/connection_db.php';
include $base_dir . 'app/Models/requests.users.php';

// Determine which profile to show (optional ?id=)
$profile_user_id = isset($_GET['id']) ? (int)$_GET['id'] : $_SESSION['user_id'];
$profile_user = trouveParId($db, $profile_user_id);
if (count($profile_user) === 0) {
  // user not found
  header('Location: ' . $base_url . '/app/Views/home.php');
  exit;
}
$profile_user = $profile_user[0];

// Check follow/favorite status for current logged-in user
$viewer_id = $_SESSION['user_id'];
$is_following = false;
$is_favorited = false;
if ($viewer_id !== $profile_user_id) {
  $is_following = estSuivi($db, $viewer_id, $profile_user_id);
  $is_favorited = estFavori($db, $viewer_id, $profile_user_id);
}

// HEADER
include $base_dir . "/app/Views/Components/header.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>KeepMyPet - Mon profil</title>
  <link rel="stylesheet" href="<?php echo $base_url; ?>/public/assets/css/profile.css">
</head>

<body>
  <div class="profile-page">

    <div class="profile-hero">
      <div class="profile-hero-inner">
        <div class="avatar">
          <?php if (!empty($_SESSION['user_first_name'])): ?>
            <span class="avatar-initial"><?php echo strtoupper(substr($_SESSION['user_first_name'], 0, 1)) . strtoupper(substr($_SESSION['user_last_name'] ?? '', 0, 1)); ?></span>
          <?php else: ?>
            <span class="avatar-initial">JD</span>
          <?php endif; ?>
        </div>

        <div class="profile-info">
          <h1 class="name"><?php echo htmlspecialchars($profile_user['first_name'] . ' ' . $profile_user['last_name']); ?></h1>
          <div class="meta">
            <span class="rating">⭐ <strong>5</strong>(18 avis)</span>
            <span class="joined">📅 02/08/2024</span>
            <span class="location">📍 Paris</span>
          </div>
        </div>

        <div class="profile-actions">
          <?php if ($viewer_id !== $profile_user_id): ?>
            <button id="followBtn" class="btn follow <?php echo $is_following ? 'following' : ''; ?>" data-target-user-id="<?php echo $profile_user_id; ?>"><?php echo $is_following ? 'Suivi' : 'Suivre'; ?></button>
            <button id="moreBtn" class="btn ghost">⋮</button>
            <button id="starBtn" class="icon-btn <?php echo $is_favorited ? 'starred' : ''; ?>" data-target-user-id="<?php echo $profile_user_id; ?>"><?php echo $is_favorited ? '★' : '☆'; ?></button>
          <?php else: ?>
            <a href="<?php echo $base_url; ?>/app/Views/profile_settings.php" id="editProfileBtn" class="btn">Modifier profil</a>
            <button id="moreBtn" class="btn ghost">⋮</button>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="profile-content">
      <div class="left-col">
        <div class="ad-card">
          <div class="ad-left">
            <div class="ad-avatar">🐶</div>
          </div>
          <div class="ad-body">
            <h3>Rocky</h3>
            <p>Gardiennage à Paris 18e du 15 au 20 novembre 2025</p>
          </div>
          <div class="ad-right">
            <div class="price">⭐ 4.8<br><span>25 € / jour</span></div>
          </div>
        </div>

        <div class="ad-card">
          <div class="ad-left">
            <div class="ad-avatar">🐱</div>
          </div>
          <div class="ad-body">
            <h3>Milo</h3>
            <p>Gardiennage à Lille pour le 15 décembre 2025</p>
          </div>
          <div class="ad-right">
            <div class="price">⭐ 4.5<br><span>27 € / jour</span></div>
          </div>
        </div>

      </div>

      <aside class="right-col">
        <div class="detail-box">
          <h4>Gardiennage à domicile</h4>
          <p><strong>Titre :</strong> Garde d'un chien labrador pendant les vacances</p>
          <p><strong>Type :</strong> Gardiennage</p>
          <p><strong>Animal :</strong> Chien • Labrador • Rocky</p>
          <p><strong>Lieu :</strong> Paris 18e</p>
          <p><strong>Dates :</strong> Du 15 au 20 novembre 2025</p>
          <p><strong>Tarif :</strong> 25 € / jour</p>
        </div>
      </aside>
    </div>

  </div>

  <script src="<?php echo $base_url; ?>/public/assets/js/profile.js"></script>
</body>

</html>

<?php
// FOOTER
include $base_dir . '/app/Views/Components/footer.php';
?>