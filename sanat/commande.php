<?php

include 'connexion.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>

    <section class="show-order">
        <h1 class="heading">votre commande</h1>
        <div class="box-container">

            <?php
            $show_order = $conn->prepare("SELECT * FROM `commande` WHERE user_id = ? ");
            $show_order->execute([$user_id]);
            if ($show_order->rowCount() > 0) {
                while ($fetch_order = $show_order->fetch(PDO::FETCH_ASSOC)) {

            ?>
            <div class="box">
                <p> placer le : <span><?= $fetch_order['placé_sur'] ?></span></p>
                <p> nom : <span><?= $fetch_order['name'] ?></span></p>
                <p> numéro : <span><?= $fetch_order['number'] ?></span></p>
                <p> email : <span><?= $fetch_order['email'] ?></span></p>
                <p> adresse : <span><?= $fetch_order['address'] ?></span></p>
                <p> votre commande : <span><?= $fetch_order['total_produits'] ?></span></p>
                <p> prix total = <span><?= $fetch_order['prix_total'] ?> €</span></p>
                <p> mode de paiement: <span><?= $fetch_order['method'] ?></span></p>
                <p> statu de paiement: <span style="color:<?php if ($fetch_order['statu_paiement'] == 'attente') {
                                                                        echo 'red';
                                                                    } else {
                                                                        echo 'green';
                                                                    } ?>"><?= $fetch_order['statu_paiement'] ?></span>
                </p>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">aucune commande lancée</p>';
            }
            ?>
        </div>
    </section>





    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="./script.js"></script>

</body>

</html>