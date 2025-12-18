<?php
// Define the base
$base_url = "/keep-my-pet/";  // For HTML links
$base_dir = __DIR__ . "/../../../";  // For PHP includes
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?php echo $base_url; ?>/public/assets/css/Components/sign_up.css">
</head>

<body>

  <div class="right">
    <label>MAIL</label>
    <input type="text" class="input">

    <div class="row">
      <div class="col">
        <label>NOM</label>
        <input type="text" class="input">
      </div>

      <div class="col">
        <label>PRÉNOM</label>
        <input type="text" class="input">
      </div>
    </div>


    <label>MOT DE PASSE</label>
    <input type="text" class="input">

    <label>CONFIRMER LE MOT DE PASSE</label>
    <input type="text" class="input">

    <a href="<?php echo $base_url; ?>/app/Views/home.php"><button class="btn">S'INSCRIRE</button></a>


    <div class="links">
      <a href="<?php echo $base_url; ?>/app/Views/log_in.php">SE CONNECTER</a>
    </div>
  </div>
</body>

</html>