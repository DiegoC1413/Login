<?php
require 'database.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nombre'])) {
  $sql = "INSERT INTO user (email, password, nombre) VALUES (:email, :password, :nombre)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':email', $_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $stmt->bindParam(':password', $password);
  $stmt->bindParam(':nombre', $_POST['nombre']);

  if ($stmt->execute()) {
    $message = 'Successfully created new user';
  } else {
    $message = 'Sorry, there must have been an issue creating your account';
  }
} else {
  $message = 'Please fill in all the required fields';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SignUp</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>SignUp</h1>
    <span>or <a href="login.php">Login</a></span>

    <form action="signup.php" method="POST">
        <input name="nombre" type="text" placeholder="Ingrese Su Nombre">            
        <input name="email" type="text" placeholder="Ingrese su  email">
        <input name="password" type="password" placeholder="Ingrese su Password">
        <input type="submit" value="Submit">
    </form>

  </body>
</html>
