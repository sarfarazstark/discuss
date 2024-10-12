<?php
$answers = $crud->get_question_responses($question_id);
?>
<?php foreach ($answers as $answer) : ?>
<div class="p-2 d-flex flex-wrap align-items-center gap-2">
    <p class="m-0"><?= $answer['response'] ?></p>
    <div class="ms-auto badge rounded-pill text-bg-dark">
        <a href="?userid=<?= $answer['user_id'] ?>" class="text-white"><?= $answer['user'] ?></a>
        <small> - <?= timeAgo($answer['created_at']) ?></small>
    </div>
</div>
<hr>
<?php endforeach ?>