<?php
// Define the base
$base_url = "/keep-my-pet/";  // For HTML links
$base_dir = __DIR__ . "/../../";  // For PHP includes

// HEADER
include $base_dir . "/app/Views/Components/header.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>KeepMyPet - Contact</title>
  <link rel="stylesheet" href="<?php echo $base_url; ?>/public/assets/css/contact.css">
</head>

<body>
</body>

</html>

<?php
// FOOTER
include $base_dir . '/app/Views/Components/footer.php';
?>