<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discuss</title>
    <link rel="shortcut icon" href="./public/favicon.png" type="image/x-icon">
    <?php require './client/common_files.php' ?>
</head>

<body>
    <?php
    session_start();
    include './client/header.php';
    require './server/db.php';
    include 'server/crud.php';

    // include 'server/connection.php';
    if (!isset($_SESSION['username']) && isset($_GET['signup'])) {
        include './client/signup.php';
    } else if (!isset($_SESSION['username']) && isset($_GET['login'])) {
        include './client/login.php';
    } else if (isset($_GET['ask'])) {
        if (!isset($_SESSION['username'])) {
            header('Location: ./?login=true');
            exit();
        }
        include './client/ask.php';
    } else if (isset($_GET['question'])) {
        include './client/response.php';
    } else {
        include './client/questions.php';
    }
    ?>
</body>

</html>