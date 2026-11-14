<?php
// Inclusion de la connexion à la base de données
require_once "db.php";

// 1. Récupération des données (Page 23 et 25)
$sqlreq = "SELECT * FROM commande";
$stmt = $pdo->prepare($sqlreq);
$stmt->execute();
// fetchAll(PDO::FETCH_ASSOC) retourne un tableau associatif de toutes les lignes
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. Calcul du total global
$totalGlobal = 0;
foreach ($commandes as $cmd) {
    $totalGlobal += $cmd['total'];
}
$nombreCommandes = count($commandes);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - DOUAA FRAGRANCE</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <nav>
        <strong>DOUAA FRAGRANCE</strong> |
        <a href="acceuil.html">Accueil</a> |
        <a href="catalogue.html">Catalogue</a> |
        <a href="commande.html">Commande</a> |
        <a href="panier.php">Panier</a> 
          <button type="button">Connexion</button>
        <button type="button">S'inscrire</button>
     
    </nav>

    <h1>Tableau de Bord Administrateur</h1>

    <!-- Affichage des statistiques -->
    <div class="stats-container">
        <div class="stat-card">
            <h3>Nombre de commandes</h3>
            <p><?php echo $nombreCommandes; ?></p>
        </div>
        <div class="stat-card">
            <h3>Chiffre d'Affaires (TTC)</h3>
            <p><?php echo $totalGlobal; ?> DH</p>
        </div>
    </div>

    <h2>Historique des commandes</h2>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Client</th>
                <th>Catégorie</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($nombreCommandes == 0): ?>
                <tr>
                    <td colspan="8">Aucune commande enregistrée pour le moment.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($commandes as $cmd): ?>
                    <tr>
                        <!-- On utilise les noms des colonnes de la base de données -->
                        <td><?php echo htmlspecialchars($cmd['idCommande']); ?></td>
                        <td><?php echo htmlspecialchars($cmd['dateCommande']); ?></td>
                        <td><?php echo htmlspecialchars($cmd['nomClient']); ?></td>
                        <td><?php echo htmlspecialchars($cmd['categorie']); ?></td>
                        <td><?php echo htmlspecialchars($cmd['produit']); ?></td>
                        <td><?php echo htmlspecialchars($cmd['quantite']); ?></td>
                        <td><?php echo htmlspecialchars($cmd['prix']); ?> DH</td>
                        <td><strong><?php echo htmlspecialchars($cmd['total']); ?> DH</strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>