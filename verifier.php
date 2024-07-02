<?php

include 'connexion.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:acceuil.php');
}
if (isset($_POST['commande'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = $_POST['appartement'] . ',' . $_POST['rue'] . ',' . $_POST['ville'] . ',' . $_POST['nationalite'] . ',' . $_POST['pays']
        . '-' . $_POST['code_pin'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_produits = $_POST['total_produits'];
    $total_produits = filter_var($total_produits, FILTER_SANITIZE_STRING);
    $prix_total = $_POST['prix_total'];
    $prix_total = filter_var($prix_total, FILTER_SANITIZE_STRING);

    $verifier_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $verifier_cart->execute([$user_id]);

    if ($verifier_cart->rowCount() > 0) {
        $insert_commande = $conn->prepare(("INSERT INTO `commande` (user_id,name, number, email,method,address,total_produits,prix_total) VALUES (?,?,?,?,?,?,?,?)"));
        $insert_commande->execute([
            $user_id, $name, $number, $email, $method, $address, $total_produits, $prix_total
        ]);
        $message[] = 'votre commande est passer';
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);
    } else {
        $message[] = 'votre panier est vide';
    }
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>

    <section class="verifier">
        <h1 class="heading">votre commande</h1>
        <div class="display-orders">

            <?php
            $Total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                    $Total += ($fetch_cart['prix'] * $fetch_cart['quantity']);
                    $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['quantity'] . ') -';
                    $total_produits = implode($cart_items);

            ?>
                    <p><?= $fetch_cart['name']; ?> <span><?= $fetch_cart['prix']; ?> € x <?= $fetch_cart['quantity']; ?></span>
                    </p>
            <?php

                }
            } else {
                echo '<p class="empty">votre panier est vide</p>';
            }
            ?>

        </div>

        <p class="total">Total = <span><?= $Total; ?> €</span></p>

        <form action="" method="post">

            <h1 class="heading">passer la commande</h1>

            <input type="hidden" name="total_produits" value="<?= $total_produits; ?>">
            <input type="hidden" name="prix_total" value="<?= $Total; ?>">
            <div class="flex">
                <div class="inputBox">
                    <span>votre nom :</span>
                    <input type="text" maxlength="20" placeholder="entrer votre nom" required class="box" name="name">
                </div>
                <div class="inputBox">
                    <span>votre numéro :</span>
                    <input type="number" min="0" max="999999999999999" onkeypress="if(this.value.length == 15) return false;" placeholder="entrer votre numéro" required class="box" name="number">
                </div>
                <div class="inputBox">
                    <span>votre email :</span>
                    <input type="email" maxlength="30" placeholder="entrer votre email" required class="box" name="email">
                </div>
                <div class="inputBox">
                    <span>mode de paiement :</span>
                    <select name="method" class="box">
                        <option value="paiement à la livraison">paiement à la livraison</option>
                        <option value="paypal">paypal</option>
                        <option value="carte de crédit">carte de crédit</option>
                        <option value="payer">payer</option>

                    </select>
                </div>
                <div class="inputBox">
                    <span>votre adresse :</span>
                    <input type="text" maxlength="50" placeholder="exemple appartement" required class="box" name="appartement">
                </div>
                <div class="inputBox">
                    <span>votre ruelle :</span>
                    <input type="text" maxlength="50" placeholder="exemple la rue" required class="box" name="rue">
                </div>
                <div class="inputBox">
                    <span>votre ville :</span>
                    <input type="text" maxlength="20" placeholder="exemple ouagadougou" required class="box" name="ville">
                </div>
                <div class="inputBox">
                    <span>votre nationalité :</span>
                    <input type="text" maxlength="20" placeholder="exemple burkinabé" required class="box" name="nationalite">
                </div>
                <div class="inputBox">
                    <span>votre pays:</span>
                    <input type="text" maxlength="20" placeholder="exemple Burkina Faso" required class="box" name="pays">
                </div>
                <div class="inputBox">
                    <span>code pin :</span>
                    <input type="number" min="0" max="999999" placeholder="exemple 123456" required class="box" name="code_pin" onkeypress="if(this.value.length == 6) return false;">
                </div>
            </div>
            <input type="submit" value="commander" class="btn <?= ($Total > 1) ? '' : 'disabled'; ?>" name="commande">
        </form>
    </section>





    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="./script.js"></script>

</body>

</html>