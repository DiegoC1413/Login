<?php
session_start();

require 'database.php';

if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, email, password, nombre FROM user WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = null;

  if (count($results) > 0) {
    $user = $results;
  }
}

// Buscar registros
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $searchResults = $conn->prepare('SELECT id, email, nombre FROM user WHERE email LIKE :search OR nombre LIKE :search');
  $searchResults->bindValue(':search', '%' . $search . '%');
  $searchResults->execute();
  $users = $searchResults->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Bienvenido a tu WebApp</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require 'partials/header.php' ?>

<?php if (!empty($user)): ?>
  <br> Bienvenido, <?= $user['nombre']; ?>
  <br>Haz iniciado sesión correctamente
  <form method="GET" action="index.php">
    <input type="text" name="search" placeholder="Para buscar registros, ingrese un nombre" value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
    <button type="submit">Buscar</button>
  </form>

  <?php if (isset($users)): ?>
    <h2>Resultados de búsqueda:</h2>
    <?php if (count($users) > 0): ?>
      <ul>
        <?php foreach ($users as $user): ?>
          <li><?= $user['nombre']; ?> - <?= $user['email']; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No se encontraron usuarios registrados con ese criterio de búsqueda.</p>
    <?php endif; ?>
  <?php endif; ?>

  <a href="logout.php">Cerrar sesión</a>
<?php else: ?>
  <h1>Inicia sesión o regístrate</h1>

  <a href="login.php">Iniciar sesión</a> or
  <a href="signup.php">Regístrate</a>
<?php endif; ?>
</body>
</html