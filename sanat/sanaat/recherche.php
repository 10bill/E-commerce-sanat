<?php

include 'connexion.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
include 'wishlist_cart.php';

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>

    <section class="recherche">
        <form action="" method="post">
            <input type="text" class="box" maxlength="100" placeholder="recherche..." required name="recherche_box">
            <button type="submit" class="fas fa-search" name="search-btn"></button>
        </form>
    </section>

    <section class="produits" style="padding-top: 0; min-height:100vh;">
        <div class="box-container">

            <?php
            if (isset($_POST['recherche_box']) or isset($_POST['search_btn'])) {
                $recherche_box = $_POST['recherche_box'];
                $select_produit = $conn->prepare("SELECT * FROM `produits` WHERE name LIKE '%{$recherche_box}%'");
                $select_produit->execute();
                if ($select_produit->rowCount() > 0) {
                    while ($fetch_produit = $select_produit->fetch(PDO::FETCH_ASSOC)) {
            ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="pid" value="<?= $fetch_produit['id']; ?>">
                            <input type="hidden" name="name" value="<?= $fetch_produit['name']; ?>">
                            <input type="hidden" name="prix" value="<?= $fetch_produit['prix']; ?>">
                            <input type="hidden" name="image" value="<?= $fetch_produit['image_01']; ?>">


                            <button type="submit" name="ajouter_à_la_liste" class="fas fa-heart"></button>
                            <a href="vue_rapide.php?pid=<?= $fetch_produit['id']; ?>" class="fas fa-eye"></a>
                            <img src="uploaded_img/<?= $fetch_produit['image_01']; ?> " class="image" alt="">
                            <div class="name"><?= $fetch_produit['name']; ?></div>
                            <div class="flex">
                                <div class="prix">$<span><?= $fetch_produit['prix']; ?></span>/-
                                </div>
                                <input type="number" name="qte" class="qte" min="1" max="99" value="1" onkeypress="if(this.value.length ==2) return false;">
                            </div>
                            <input type="submit" value="ajouter au panier" name="ajouter_au_panier" class="btn">
                        </form>
            <?php
                    }
                } else {
                    echo '<p class="empty"> aucun resultat</p>';
                }
            }
            ?>
        </div>
    </section>




    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="./script.js"></script>

</body>

</html>