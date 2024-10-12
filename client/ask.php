<div class="container col-sm-6 offset-sm-3 my-5 px-5">
    <h3 class="text-center">Ask your question.</h3>
    <form class="mt-5" method="post" action="server/requests.php">
        <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert"><?= $_GET['error'] ?></div>
        <?php endif; ?>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="title" id="title" placeholder="name@example.com">
            <label for="title">Title</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Leave a comment here" id="description" style="height: 100px"
                name="description"></textarea>
            <label for="description">Description</label>
        </div>

        <!-- Category -->
        <?php
        try {
            $categories = $crud->get_category();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } ?>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" aria-label="Default select example">
                <option selected disabled>Select a category</option>
                <?php foreach ($categories as $category) : ?>
                <option value="<?= $category['id'] ?>"><?= $category['category_name'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="ask">Ask a question</button>
    </form>
</div>