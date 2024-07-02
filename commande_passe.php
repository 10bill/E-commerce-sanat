<?php

include 'connexion.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admins.php');
};
if (isset($_POST['modifier_paiement'])) {
    $commande_id = $_POST['commande_id'];
    $statu_paiement = $_POST['statu_paiement'];
    $modifier_statu = $conn->prepare("UPDATE `commande` SET statu_paiement = ? WHERE id = ?");
    $modifier_statu->execute([$statu_paiement, $commande_id]);
    $message[] = 'Statu de paiement modifier';
}
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_commande = $conn->prepare("DELETE FROM `commande` WHERE id = ?");
    $delete_commande->execute([$delete_id]);
    header('location:commande_passe.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <?php include 'admin_header.php' ?>

    <section class="commande">
        <h1 class="heading">Commandes passées</h1>
        <div class="box-container">

            <?php
            $select_commande = $conn->prepare("SELECT * FROM `commande`");
            $select_commande->execute();
            if ($select_commande->rowCount() > 0) {
                while ($fetch_commande = $select_commande->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <p> ID de l'utilisateur : <span><?= $fetch_commande['user_id']; ?></span> </p>
                        <p> Placer le : <span><?= $fetch_commande['placed_on']; ?></span> </p>
                        <p> nom : <span><?= $fetch_commande['name']; ?></span> </p>
                        <p> email : <span><?= $fetch_commande['email']; ?></span> </p>
                        <p> number : <span><?= $fetch_commande['number']; ?></span> </p>
                        <p> adresse : <span><?= $fetch_commande['address']; ?></span> </p>
                        <p> produit total : <span><?= $fetch_commande['total_produits']; ?></span> </p>
                        <p> Prix total = <span>$<?= $fetch_commande['prix_total']; ?>/-</span> </p>
                        <p> method : <span><?= $fetch_commande['method']; ?></span> </p>
                        <form action="" method="POST">
                            <input type="hidden" name="commande_id" value="<?= $fetch_commande['id']; ?>">

                            <select name="statu_paiement" class="drop-down">
                                <option value="" selected disabled><?= $fetch_commande['statu_paiement']; ?></option>
                                <option value="attente">Attente</option>
                                <option value="complete">completer</option>
                            </select>
                            <div class="flex-btn">
                                <input type="submit" value="modifier" class="btn" name="modifier_paiement">
                                <a href="commande_passe.php?delete=<?= $fetch_commande['id']; ?>" class="delete-btn" onclick="return confirm('Voulez vous supprimer cette commande?');">Supprimer</a>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">Aucune commande récue </p>';
            }
            ?>
        </div>
    </section>

    <script type="text/javascript" src="./admin_script.js"></script>
</body>

</html>