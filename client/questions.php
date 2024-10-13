<?php
// require './server/db.php';
// require './server/crud.php';

if (isset($_GET['category'])) {
    $questions = $crud->get_questions(null, $_GET['category']);
} else if (isset($_GET['latest'])) {
    $questions = $crud->get_questions_by_response('created_at');
} else if (isset($_GET['userid'])) {
    $questions = $crud->get_questions_by_user($_GET['userid']);
} else if (isset($_GET['search'])) {
    $questions = $crud->search_question($_GET['search']);
} else {
    $questions = $crud->get_questions_by_response('response_count');
}
$categories = $crud->get_category();
?>

<div class="container home-container my-4">
    <div class="container-sm c-query max-w-1000">
        <h2 class="text-center mb-4"><?= isset($_GET['search']) ? "Search results: " : 'Questions'  ?></h2>
        <?php if (isset($_GET['message'])): ?>
            <script>
                alert('<?= $_GET['message'] ?>')
            </script>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <script>
                alert('<?= $_GET['error'] ?>')
            </script>
        <?php endif; ?>
        <div class="grid grid-cols-2 gap-4">
            <?php foreach ($questions as $question) : ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0 small fw-bold text-body-tertiary"><?= $question['category_name'] ?></p>
                        <p class="m-0 small"><?= timeAgo($question['created_at']) ?></p>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title"><?= $question['title'] ?></h5>
                        <p class="card-text">
                            <?php
                            $description = explode(' ', $question['description']);
                            if (count($description) > 10) {
                                $description = array_slice($description, 0, 25);
                                echo implode(' ', $description) . '...';
                            } else {
                                echo implode(' ', $description);
                            }
                            ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-end">
                            <p class="m-0">Asked by: <a href="?userid=<?= $question['user_id'] ?>"
                                    class="link-primary"><?= $question['user'] ?></a></p>
                            <a href="?question=<?= $question['id'] ?>"
                                class="btn btn-outline-primary ms-auto me-2">Answer</a>


                            <?php if (isset($_GET['userid']) && isset($_SESSION['user_id']) && $question['user_id'] === $_SESSION['user_id']) : ?>
                                <form action="server/requests.php" method="post">
                                    <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
                                    <input type="hidden" name="user_id" value="<?= $question['user_id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            <?php endif ?>


                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="aside">
        <h2 class="text-center mb-4">Category</h2>
        <div class="d-flex flex-wrap align-item-start gap-2 px-2">
            <h6 class="mb-0"><a href="/discuss" class="badge
            <?php
            if (!isset($_GET['category'])) {
                echo 'text-bg-dark';
            } else {
                echo 'text-bg-primary';
            } ?> category">All</a></h6>

            <?php foreach ($categories as $category) : ?>
                <h6 class="m-0">
                    <a href="?category=<?= $category['id'] ?>" class="badge
                        <?php
                        if (isset($_GET['category']) and $category['id'] == $_GET['category']) {
                            echo 'text-bg-dark';
                        } else {
                            echo 'text-bg-primary';
                        } ?>
                        category">
                        <?= $category['category_name'] ?>
                    </a>
                </h6>
            <?php endforeach ?>
        </div>

    </div>
</div>
