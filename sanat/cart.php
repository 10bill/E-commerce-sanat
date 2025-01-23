<?php

include 'connexion.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:connexion_user.php');
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:connexion_user.php');
}

if (isset($_POST['delete'])) {
    $cart_id = $_POST['cart_id'];
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart->execute([$cart_id]);
    $message[] = 'article supprimer';
}
if (isset($_GET['tout_supprimer'])) {
    $tout_supprimer = $_GET['tout_supprimer'];
    $tout_supprimer_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $tout_supprimer_cart->execute([$user_id]);
    header('location:cart.php');
}
if (isset($_POST['modifier_qte'])) {
    $cart_id = $_POST['cart_id'];
    $qte = $_POST['qte'];
    $modifier_qte = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
    $modifier_qte->execute([$qte, $cart_id]);
    $message[] = 'quantité du panier modifier';
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>


    <section class="produits">
        <h1 class="heading">votre panier</h1>
        <div class="box-container">

            <?php
            $Total = 0;
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {

            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                <a href="vue_rapide.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
                <img src="uploaded_img/<?= $fetch_cart['image']; ?>" class="image" alt="">
                <div class="name"><?= $fetch_cart['name']; ?></div>
                <div class="flex">
                    <div class="prix"><span><?= $fetch_cart['prix']; ?></span> €</div>
                    <input type="number" name="qte" class="qte" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>"
                        onkeypress="if(this.value.length ==2) return false;">
                    <button type="submit" class="fas fa-edit" name="modifier_qte"></button>
                </div>
                <div class="sub-total">sous-total :
                    <span>$<?= $sub_total = ($fetch_cart['prix'] * $fetch_cart['quantity']); ?>/-</span>
                </div>

                <input type="submit" value="effacer l'article" onclick="return confirm('effacer ceci du panier ?');"
                    name="delete" class="delete-btn">
            </form>
            <?php
                    $Total += $sub_total;
                }
            } else {
                echo '<p class="empty">votre panier est vide</p>';
            }
            ?>
        </div>
        <div class="total">
            <p>Total = <span>$<?= $Total; ?>/-</span></p>
            <a href="magasin.php" class="option-btn">Continuer les achtas</a>
            <a href="cart.php?tout_supprimer" class="delete-btn <?= ($Total > 1) ? '' : 'disabled'; ?>"
                onclick="return confirm('voulez vous tous supprimer ?');">tout
                supprimer</a>
            <a href="verifier.php" class="btn <?= ($Total > 1) ? '' : 'disabled'; ?>">proceder à la vérification</a>
        </div>
    </section>




    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="./script.js"></script>

</body>

</html>