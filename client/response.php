<?php
if (isset($_GET['question'])) {
    $question_id = $_GET['question']; // get the question id from the url
    $question = $crud->get_questions($question_id, null); // get the question details from the database
    $related_questions = $crud->get_questions(null, $question['category_id']); // get the related questions from the database
}
?>
<div class="container row my-4">
    <div class="container-sm col-8 max-w-1000">
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
        <div class="card p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
                <h4><?= $question['title'] ?></h4>
                <span class="badge bg-primary"><?= $question['category_name'] ?></span>
            </div>
            <p><?= $question['description'] ?></p>
            <div class="d-flex justify-content-between align-items-start">
                <a href="?userid=<?= $question['user_id'] ?>" class="badge bg-dark"><?= $question['user'] ?></a>
                <span class="badge bg-dark"><?= timeAgo($question['created_at']) ?></span>
            </div>
        </div>
        <div class="p-4 mt-3">
            <h3>Replies:</h3>
            <hr>
            <?php include 'client/answers.php' ?>
        </div>

        <!-- Submit answer -->
        <form class="mt-3" method="post" action="server/requests.php">
            <div class="form-floating mb-3">
                <input type="hidden" name="question_id" value="<?= $question_id ?>">
                <textarea class="form-control" placeholder="Leave a comment here" id="description" style="height: 100px"
                    name="description" required></textarea>
                <label for="description">Type your answer here</label>
            </div>
            <button type="submit" class="btn btn-primary" name="response">Submit your answer</button>
        </form>

    </div>
    <div class="col-4 px-2">
        <h2 class="mb-4">Related Questions</h2>
        <div class="d-flex flex-column align-item-start gap-2">
            <?php foreach ($related_questions as $related_question) : ?>
            <?php if ($related_question['id'] == $question_id) continue; ?>
            <a href="?question=<?= $related_question['id'] ?>"
                class="border rounded border-primary text-center category py-2">
                <?= $related_question['title'] ?>
            </a>
            <?php endforeach ?>
        </div>
    </div>
</div>