<?php

include 'connexion.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['envoyer'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if ($select_message->rowCount() > 0) {
        $message[] = 'Votre message est déjà envoyer';
    } else {
        $envoyer_message = $conn->prepare("INSERT INTO `messages` (name, email, number, message) VALUES (?,?,?,?)");
        $envoyer_message->execute([$name, $email, $number, $msg]);
        $message[] = 'message envoyer';
    }
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>


    <section class="form-container">


        <form method="post" action="" class="box">
            <h3>message</h3>
            <input type="text" name="name" required placeholder="entrer votre nom" maxlength="20" class="box">
            <input type="number" name="number" required placeholder="entrer votre numéro" max="9999999999" min="0"
                class="box" onkeypress="if(this.value.length == 10) return false;">
            <input type="email" name="email" required placeholder="entrer votre email" maxlength="50" class="box">
            <textarea name="msg" placeholder="entrer votre message" required class="box" cols="30" rows="10"></textarea>
            <input type="submit" value="envoyer" class="btn" name="envoyer">
        </form>
    </section>



    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="./script.js"></script>

</body>

</html>