<?php
// Define the base
$base_url = "/App_dev_web/";  // For HTML links
$base_dir = __DIR__ . "/../../../";  // For PHP includes
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?php echo $base_url; ?>/public/assets/css/header.css">
  <script type="text/javascript" src="<?php echo $base_url; ?>/public/assets/js/header.js"></script>
</head>

<body>
  <header>
    <div class="logo-container">
      <img src="<?php echo $base_url; ?>/public/assets/images/KeepMyPet_Logo.png" alt="Logo KeepMyPet">
    </div>

    <nav class="nav-bar">
      <div id="myLinks">
        <a href="<?php echo $base_url; ?>/app/Views/home.php">Accueil</a>
        <p>|</p>
        <a href="<?php echo $base_url; ?>/app/Views/advertisements.php">Annonces</a>
        <p>|</p>
        <a href="<?php echo $base_url; ?>/app/Views/contact.php">Contact</a>
        <p>|</p>
        <a href="<?php echo $base_url; ?>/app/Views/log_in.php">Connexion</a>
      </div>
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <p class="fa fa-bars">≡</p>
      </a>
    </nav>

    <div class="lang">
      <img src="<?php echo $base_url; ?>/public/assets/images/flags/french.png" alt="Drapeau" class="flag">
      <p>FR</p>
    </div>
  </header>

</body>

</html>

<style>
  /* Debugging Borders */
  * {
    border: 1px solid red;
  }
</style>