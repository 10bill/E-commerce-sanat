<?php

include 'connexion.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin.php');
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>

    <?php include 'admin_header.php' ?>

    <section class="tableau">
        <h1 class="heading">Tableau de bord</h1>
        <div class="box-container">

            <div class="box">
                <h3>Bienvenue</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="modifier_profile.php" class="btn">Modifer le profile</a>
            </div>
            <div class="box">
                <?php
                $total_attente = 0;
                $select_attente = $conn->prepare("SELECT * FROM `commande` WHERE statu_paiement = ?");
                $select_attente->execute(['attente']);
                while ($fetch_attente = $select_attente->fetch(PDO::FETCH_ASSOC)) {
                    $total_attente += $fetch_attente['prix_total'];
                }
                ?>
                <h3><span></span><?= $total_attente; ?><span> €</span></h3>
                <p>Attente total</p>
                <a href="commande_passe.php" class="btn">Voir les commandes</a>
            </div>
            <div class="box">
                <?php
                $total_complete = 0;
                $select_complete = $conn->prepare("SELECT * FROM `commande` WHERE statu_paiement = ?");
                $select_complete->execute(['complete']);
                while ($fetch_complete = $select_complete->fetch(PDO::FETCH_ASSOC)) {
                    $total_complete += $fetch_complete['prix_total'];
                }
                ?>
                <h3><span></span><?= $total_complete; ?><span> €</span></h3>
                <p>Total completer</p>
                <a href="commande_passe.php" class="btn">Voir les commandes</a>
            </div>
            <div class="box">
                <?php
                $select_commande = $conn->prepare("SELECT * FROM `commande`");
                $select_commande->execute();
                $numero_du_commande = $select_commande->rowCount();
                ?>
                <h3><?= $numero_du_commande; ?></h3>
                <p>Commande total</p>
                <a href="commande_passe.php" class="btn">Voir les commandes</a>
            </div>
            <div class="box">
                <?php
                $select_produits = $conn->prepare("SELECT * FROM `produits`");
                $select_produits->execute();
                $numero_du_produits = $select_produits->rowCount();
                ?>
                <h3><?= $numero_du_produits; ?></h3>
                <p>Ajouter des produits</p>
                <a href="produits.php" class="btn">Voir les produits</a>
            </div>
            <div class="box">
                <?php
                $select_user = $conn->prepare("SELECT * FROM `user`");
                $select_user->execute();
                $numero_du_user = $select_user->rowCount();
                ?>
                <h3><?= $numero_du_user; ?></h3>
                <p>Compte utilisateur</p>
                <a href="user.php" class="btn">Voir les Utilisateurs</a>
            </div>
            <div class="box">
                <?php
                $select_admins = $conn->prepare("SELECT * FROM `admins`");
                $select_admins->execute();
                $numero_du_admins = $select_admins->rowCount();
                ?>
                <h3><?= $numero_du_admins; ?></h3>
                <p>Total des admins</p>
                <a href="compte_administration.php" class="btn">Voir les admins</a>
            </div>
            <div class="box">

                <?php
                $select_messages = $conn->prepare("SELECT * FROM `messages`");
                $select_messages->execute();
                $numero_du_messages = $select_messages->rowCount();
                ?>
                <h3><?= $numero_du_messages; ?></h3>
                <p>Nouveau message</p>
                <a href="message.php" class="btn">Voir les messages</a>
            </div>
        </div>
    </section>


    <script type="text/javascript" src="./admin_script.js"></script>
</body>

</html>