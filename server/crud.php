<?php

class CRUD
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Private method to prepare and execute a statement
    private function executeStatement($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function get_category()
    {
        $sql = "SELECT * FROM category";
        $stmt = $this->executeStatement($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ask_question($title, $description, $category, $userId)
    {
        try {
            $sql = "INSERT INTO questions (title, description, category_id, user_id)
                    VALUES (:title, :description, :category, :user_id)";
            $this->executeStatement($sql, [
                'title' => $title,
                'description' => $description,
                'category' => $category,
                'user_id' => $userId
            ]);
            return header('Location: ../?message=Question added');
        } catch (PDOException $e) {
            return header('Location: ../?ask=true&error=Ask failed');
        }
    }

    // Combined method to get multiple or a single question
    public function get_questions($question_id = null, $category_id = null)
    {
        $sql = "SELECT q.id, u.id AS user_id, c.id AS category_id, c.category_name, q.title, q.description, u.username AS user, q.created_at
                FROM questions q
                JOIN category c ON q.category_id = c.id
                JOIN users u ON q.user_id = u.id";

        $params = [];

        if ($question_id) {
            $sql .= " WHERE q.id = :question_id";
            $params['question_id'] = $question_id;
        } elseif ($category_id) {
            $sql .= " WHERE q.category_id = :category_id";
            $params['category_id'] = $category_id;
        }

        $stmt = $this->executeStatement($sql, $params);
        return $question_id ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_question_response($question_id, $description, $user_id)
    {
        try {
            $sql = "INSERT INTO responses (response, question_id, user_id, created_at)
                    VALUES (:response, :question_id, :user_id, CURRENT_TIMESTAMP)";

            $this->executeStatement($sql, [
                'response' => $description,
                'question_id' => $question_id,
                'user_id' => $user_id
            ]);

            return header('Location: ../?question=' . $question_id . '&message=Answer added');
        } catch (PDOException $e) {
            echo $e->getMessage();
            return header('Location: ../?question=' . $question_id . '&error=Answer failed');
        }
    }

    public function get_question_responses($question_id)
    {
        $sql = "SELECT r.response, users.id AS user_id, users.username AS user, r.created_at
                FROM responses r
                JOIN users ON r.user_id = users.id
                WHERE r.question_id = :question_id";

        $stmt = $this->executeStatement($sql, ['question_id' => $question_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get questions by most response
    public function get_questions_by_response($column_name)
    {
        $sql = "SELECT
    q.id,
    q.user_id,
    c.category_name,
    q.title,
    q.description,
    users.username AS user,
    q.created_at AS created_at,
    COUNT(r.id) AS response_count
FROM
    questions q
JOIN
    category c ON q.category_id = c.id
JOIN
    users ON q.user_id = users.id
LEFT JOIN
    responses r ON q.id = r.question_id
GROUP BY
    q.id, c.category_name, q.title, q.description, users.username, q.created_at
ORDER BY
    $column_name DESC;
";

        $stmt = $this->executeStatement($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_questions_by_user($user_id)
    {
        $sql = "SELECT q.id, u.id AS user_id, c.category_name, q.title, q.description, u.username AS user, q.created_at
                FROM questions q
                JOIN category c ON q.category_id = c.id
                JOIN users u ON q.user_id = u.id
                WHERE q.user_id = :user_id";

        $stmt = $this->executeStatement($sql, ['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search_question($search)
    {
        $sql = "SELECT q.id, q.user_id, c.category_name, q.title, q.description, users.username AS user, q.created_at
                FROM questions q
                JOIN category c ON q.category_id = c.id
                JOIN users ON q.user_id = users.id
                WHERE q.title ILIKE :search OR q.description ILIKE :search";

        $stmt = $this->executeStatement($sql, ['search' => "%$search%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete_question($question_id)
    {
        try {
            $sql = "DELETE FROM questions WHERE id = :question_id";
            $this->executeStatement($sql, ['question_id' => $question_id]);
            return true;
        } catch (PDOException $e) {
            return header('Location: ../?error=Question delete failed');
        }
    }
};

$crud = new CRUD($pdo);