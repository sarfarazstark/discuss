<?php
session_start();
require './db.php';
require './auth.php';
require './crud.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Signup request
    if (isset($_POST['signup'])) {
        $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
        $confirm_password = htmlspecialchars($_POST['confirm_password'], ENT_QUOTES, 'UTF-8');

        if ($password === $confirm_password) {
            $check_user = $auth->get_user($username);

            if (!$check_user > 0) {
                $auth->signup($username, $email, $password);
            } else {
                header('Location: ../?signup=true&error=User already exists');
                exit();
            }
        } else {
            header('Location: ../?signup=true&error=Password not matching');
            exit();
        }
    }
    // Login request
    else if (isset($_POST['login'])) {
        $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

        $user = $auth->login($username, $password);
    }
    // Post request for asking a question
    else if (isset($_POST['ask'])) {
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $category = htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8');
        $user_id = $_SESSION['user_id'];

        echo $title . ' - ' . $description . ' - ' . $category;
        $crud->ask_question($title, $description, $category, $user_id);
    }
    // Post request for answering a question
    else if (isset($_POST['response'])) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../?login=true');
            exit();
        }
        $question_id = htmlspecialchars($_POST['question_id'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $user_id = $_SESSION['user_id'];
        $crud->insert_question_response($question_id, $description, $user_id);
    } else if (isset($_POST['delete'])) {
        $question_id = htmlspecialchars($_POST['question_id'], ENT_QUOTES, 'UTF-8');
        $user_id = $_POST['user_id'];
        if ($crud->delete_question($question_id)) {
            header("Location: ../?userid=$user_id&message=Question deleted");
            exit();
        } else {
            header("Location: ../?userid=$user_id&error=Question not deleted");
            exit();
        }
    } else {
        header('Location: ../');
        exit();
    }
} else if (isset($_GET['logout'])) {
    $auth->logout();
} else {
    header('Location: ../');
    exit();
}