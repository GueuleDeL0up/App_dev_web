<?php
// Define the base
$base_url = "/keep-my-pet/";  // For HTML links
$base_dir = __DIR__ . "/../../../";  // For PHP includes
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?php echo $base_url; ?>/public/assets/css/Components/log_in.css">
</head>

<body>

  <div class="right">

    <?php if (!empty($errors) && is_array($errors)) : ?>
      <div class="errors">
        <?php foreach ($errors as $err) : ?>
          <p class="error"><?php echo htmlspecialchars($err); ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <label>EMAIL</label>
      <input type="email" name="email" class="input" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>

      <label>MOT DE PASSE</label>
      <input type="password" name="password" class="input" required>

      <button type="submit" class="btn">Se connecter</button>
    </form>

    <div class="links">
      <a href="<?php echo $base_url; ?>/app/Views/forgotten_password.php">Mot de passe oublié</a> -
      <a href="<?php echo $base_url; ?>/app/Views/sign_up.php">S'inscrire</a>
    </div>
  </div>
</body>

</html>