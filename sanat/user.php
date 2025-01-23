<?php

include 'connexion.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admins.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_user = $conn->prepare("DELETE FROM `user` WHERE id = ?");
    $delete_user->execute([$delete_id]);
    $delete_commande = $conn->prepare("DELETE FROM `commande` WHERE user_id = ?");
    $delete_commande->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist->execute([$delete_id]);
    $delete_message = $conn->prepare("DELETE FROM `message` WHERE user_id = ?");
    $delete_message->execute([$delete_id]);
    header('location:user.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte utilisateur</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <?php include 'admin_header.php' ?>
    <section class="compte">
        <h1 class="heading">Compte utilisateur</h1>
        <div class="box-container">
            <?php
            $select_compte = $conn->prepare("SELECT * FROM `user`");
            $select_compte->execute();
            if ($select_compte->rowCount() > 0) {
                while ($fetch_compte = $select_compte->fetch(PDO::FETCH_ASSOC)) {

            ?>
                    <div class="box">
                        <p>Identifiant de l'utilisateur : <span> <?= $fetch_compte['id']; ?></span> </p>
                        <p> nom de l'utilisateur : <span><?= $fetch_compte['name']; ?></span></p>
                        <a href="user.php?delete=<?= $fetch_compte['id']; ?>" class="delete-btn" onclick="return confirm('Voulez vous supprimer cet utilisateur?');">Supprimer</a>

                    </div>
            <?php
                }
            } else {
                echo ' <p class="empty">Aucun compte disponible</p>';
            }
            ?>
        </div>
    </section>



    <script type="text/javascript" src="./admin_script.js"></script>
</body>

</html>