<?php
// Paramètres de connexion à la BD (Page 8)
$dsn = "mysql:host=localhost;dbname=douaa_fragrence_db";
$username = "root";
$password = "";

try {
    // Connexion à la BD via PDO (Page 14)
    $pdo = new PDO($dsn, $username, $password);
    // Activation du mode d'erreur (Page 9 et 14)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<p>Erreur de connexion : " . $e->getMessage() . "</p>";
    exit();
}
?>