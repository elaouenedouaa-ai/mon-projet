<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>DOUAA FRAGRENCE - Panier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        <nav>
         <strong>DOUAA FRAGRANCE</strong> | 
        <a href="acceuil.html">Accueil</a> | 
        <a href="catalogue.html">Catalogue</a> | 
        <a href="commande.html">Commande</a> | 
        <a href="panier.php">Panier</a> | 
       
        <button type="button">Connexion</button>
        <button type="button">S'inscrire</button>
    </nav>
     <h1>DOUAA FRAGRENCE </h1>
    <h2>Récapitulatif de votre commande</h2>
    </body>
</body>
</html>
<?php
// Inclusion de la connexion à la base de données
require_once "db.php";

define("TVA", 0.20);
const PRIX = [
    "Rose Divine" => 350,
    "Nuit d'Orient" => 450,
    "Oud Royal" => 600,
    "Fleur de Jasmin" => 250
];
$stock = [
    "Rose Divine" => 30,
    "Nuit d'Orient" => 30,
    "Oud Royal" => 30,
    "Fleur de Jasmin" => 30
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $nom_parfum = $_POST['parfum'];
    $contenance = $_POST['contenance'];
    $quantite = (int)$_POST['quantite'];
    $categorie = $_POST['categorie'];
    
    $total = 0;
    $message = "";

    // Vérification du stock
    if (isset($stock[$nom_parfum]) && $stock[$nom_parfum] >= $quantite) {
        $total = PRIX[$nom_parfum] * $quantite;    
        $message = "Commande validée.";
    } else {
        $message = "Erreur : Stock insuffisant pour ce parfum.";
    }

    if ($total > 0) {
        $totalTVA = $total * TVA;
        $totalTTC = $total + $totalTVA;
        
        // Format de date pour MySQL (DATETIME) - Page 17 et 18
        $date_commande = date("Y-m-d H:i:s"); 

        // --- INSERTION DANS LA BASE DE DONNÉES (Page 21 et 22) ---
        $sqlreq = "INSERT INTO commande (dateCommande, nomClient, categorie, produit, quantite, prix, total) 
                   VALUES (:dateCommande, :nomClient, :categorie, :produit, :quantite, :prix, :total)";
        
        $stmt = $pdo->prepare($sqlreq);
        
        $stmt->execute([
            ":dateCommande" => $date_commande,
            ":nomClient" => $nom,
            ":categorie" => $categorie,
            ":produit" => $nom_parfum,
            ":quantite" => $quantite,
            ":prix" => PRIX[$nom_parfum],
            ":total" => $totalTTC
        ]);
        // -----------------------------------------------------------

        // Affichage HTML (ton code existant)
        echo "<h2>Récapitulatif de la commande</h2>";
        echo "<p><strong>Message :</strong> " . $message . "</p>";
        echo "<p><strong>Client :</strong> " . $nom . "</p>";
        echo "<p><strong>Parfum :</strong> " . $nom_parfum . " (" . $categorie . ")</p>";
        echo "<p><strong>Contenance :</strong> " . $contenance . "</p>";
        echo "<p><strong>Quantité :</strong> " . $quantite . "</p>";
        echo "<p><strong>Date :</strong> " . $date_commande . "</p>";
        echo "<p>Total HT : " . $total .  " Dh</p>";
        echo "<p>TVA (20%) : " . $totalTVA . " Dh</p>";
        echo "<h3>Total TTC : " . $totalTTC . " Dh</h3>";  
    } else {
        echo "<p>" . $message . "</p>";
    }
} else {
    echo "<p>Veuillez remplir le formulaire de commande d'abord.</p>";
}
?>

