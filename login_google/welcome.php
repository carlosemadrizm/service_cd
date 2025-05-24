
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>

<h2>Bienvenido, <?= htmlspecialchars($user['name']) ?>!</h2>
<p>Email: <?= htmlspecialchars($user['email']) ?></p>
<img src="<?= htmlspecialchars($user['picture']) ?>" width="100" alt="Foto de perfil" />
<br>
<a href="logout.php">Cerrar sesión</a>
