<?php

include 'connexion.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admins.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_admin = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
    $delete_admin->execute([$delete_id]);
    header('location:compte_administration.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte d'administration</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <?php include 'admin_header.php' ?>

    <section class="compte">
        <h1 class="heading">Compte d'administrateur</h1>
        <div class="box-container">
            <div class="box">
                <p>enregistrer un nouvel administrateur</p>
                <a href="inscription.php" class="option-btn">Enregistrer</a>
            </div>
            <?php
            $select_compte = $conn->prepare("SELECT *FROM `admins`");
            $select_compte->execute();
            if ($select_compte->rowCount() > 0) {
                while ($fetch_compte = $select_compte->fetch(PDO::FETCH_ASSOC)) {

            ?>
                    <div class="box">
                        <p>Identifiant de l'utilisateur : <span> <?= $fetch_compte['id']; ?></span> </p>
                        <p> nom de l'utilisateur : <span><?= $fetch_compte['name']; ?></span></p>
                        <div class="flex-btn">
                            <a href="compte_administration.php?delete=<?= $fetch_compte['id']; ?>" class="delete-btn" onclick="return confirm('Voulez vous supprimer ce compte?');">Supprimer</a>

                            <?php
                            if ($fetch_compte['id'] == $admin_id) {
                                echo '  <a href="modifier_profile.php" class="option-btn">modifier</a>';
                            }
                            ?>
                        </div>

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