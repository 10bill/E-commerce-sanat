<?php

include 'connexion.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:message.php');
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <?php include 'admin_header.php' ?>

    <section class="messages">
        <h1 class="heading">nouveau message</h1>
        <div class="box-container">

            <?php

            $select_messages = $conn->prepare("SELECT * FROM `messages` ");
            $select_messages->execute();
            if ($select_messages->rowCount() > 0) {
                while ($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)) {

            ?>
                    <div class="box">
                        <p> Identifiant utilisateur : <span><?= $fetch_messages['user_id']; ?></span></p>
                        <p> nom : <span><?= $fetch_messages['name']; ?></span></p>
                        <p> email : <span><?= $fetch_messages['email']; ?></span></p>
                        <p> numéro : <span><?= $fetch_messages['number']; ?></span></p>
                        <p> message : <span><?= $fetch_messages['message']; ?></span></p>
                        <a href="message.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('Voulez vous supprimer ce message?');">Supprimer</a>


                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">Aucun message récu</p>';
            }
            ?>
        </div>
    </section>

    <script type="text/javascript" src="./admin_script.js"></script>
</body>

</html>