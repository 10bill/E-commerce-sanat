<?php

include 'connexion.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:connexion_user.php');
}
include 'wishlist_cart.php';
if (isset($_POST['delete'])) {
    $wishlist_id = $_POST['wishlist_id'];
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
    $delete_wishlist->execute([$wishlist_id]);
    $message[] = 'article supprimer';
}
if (isset($_GET['tout_supprimer'])) {
    $tout_supprimer = $_GET['tout_supprimer'];
    $tout_supprimer_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $tout_supprimer_wishlist->execute([$user_id]);
    header('location:wishlist.php');
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>list de souhait</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>

    <section class="produits">
        <h1 class="heading">votre liste</h1>
        <div class="box-container">

            <?php
            $Total = 0;
            $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $select_wishlist->execute([$user_id]);
            if ($select_wishlist->rowCount() > 0) {
                while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                    $Total += $fetch_wishlist['prix'];
            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
                <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
                <input type="hidden" name="prix" value="<?= $fetch_wishlist['prix']; ?>">
                <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
                <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                <a href="vue_rapide.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
                <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" class="image" alt="">
                <div class="name"><?= $fetch_wishlist['name']; ?></div>
                <div class="flex">
                    <div class="prix">$<span><?= $fetch_wishlist['prix']; ?></span>/-</div>
                    <input type="number" name="qte" class="qte" min="1" max="99" value="1"
                        onkeypress="if(this.value.length ==2) return false;">
                </div>
                <input type="submit" value="ajouter au panier" name="ajouter_au_panier" class="btn">
                <input type="submit" value="effacer l'article" onclick="return confirm('effacer ceci de la liste ?');"
                    name="delete" class="delete-btn">
            </form>
            <?php
                }
            } else {
                echo '<p class="empty">votre liste est vide</p>';
            }
            ?>
        </div>
        <div class="total">
            <p>Total = <span>$<?= $Total; ?>/-</span></p>
            <a href="magasin.php" class="option-btn">Continuer les achtas</a>
            <a href="wishlist.php?tout_supprimer" class="delete-btn <?= ($Total > 1) ? '' : 'disabled'; ?>"
                onclick="return confirm('voulez vous tous supprimer ?');">tout
                supprimer</a>
        </div>
    </section>




    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="./script.js"></script>

</body>

</html>