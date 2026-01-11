<?php

class LoginController
{
  /**
   * Handle login form submission and authentication.
   *
   * @param PDO $db
   * @param string $base_dir Path to project root with trailing slash
   * @param string $base_url Base URL (for redirects)
   * @return array List of error messages (empty if none)
   */
  public static function handle(PDO $db, string $base_dir, string $base_url): array
  {
    $errors = [];

    // Start session if not started
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Load user model
    include_once $base_dir . 'app/Models/requests.users.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return $errors;
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
      $errors[] = 'Email et mot de passe requis.';
      return $errors;
    }

    try {
      $users = trouveParEmail($db, $email);
      if (count($users) === 0) {
        $errors[] = 'Identifiants invalides.';
        return $errors;
      }

      $user = $users[0];

      if (!password_verify($password, $user['password'])) {
        $errors[] = 'Identifiants invalides.';
        return $errors;
      }

      // Auth success: set session values
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_email'] = $user['email'];
      $_SESSION['user_first_name'] = $user['first_name'];
      $_SESSION['user_last_name'] = $user['last_name'];

      // Redirect to home or dashboard
      header('Location: ' . $base_url . '/app/Views/home.php');
      exit;
    } catch (Exception $e) {
      $errors[] = 'Erreur serveur lors de la connexion.';
    }

    return $errors;
  }
}
