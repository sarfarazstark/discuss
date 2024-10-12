<?php
class Auth
{
    private $db;

    public function __construct($db_connection)
    {
        $this->db = $db_connection;
    }

    public function signup($username, $email, $password)
    {

        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $statement = $this->db->prepare($sql);
            $statement->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);

            $id = $this->db->lastInsertId();

            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $id;
            header("Location: ../?message=Welcome $username");
            exit();
        } catch (PDOException $e) {
            return header('Location: ../?signup=true&error=Signup failed');
        }
    }

    public function login($username, $password)
    {
        try {

            $sql = "SELECT * FROM users WHERE username = :username";
            $statement = $this->db->prepare($sql);
            $statement->execute(['username' => $username]);
            $user = $statement->fetch();

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['user_id'] = $user['id'];
                    return header("Location: ../?message=Welcome $username");
                } else {
                    return header('Location: ../?login=true&error=Invalid username or password');
                }
            } else {
                return header('Location: ../?login=true&error=User not found');
            }
        } catch (PDOException $e) {
            return header('Location: ../?login=true&error=Login failed');
        }
    }

    public function get_user($username)
    {
        $sql = "SELECT count(*) FROM users WHERE username = :username";
        $statement = $this->db->prepare($sql);

        $statement->execute(['username' => $username]);

        return $statement->fetchColumn();
    }

    public function logout()
    {
        session_destroy();
        header('Location: ../');
        exit();
    }
}

$auth = new Auth($pdo);