<select class="form-select" id="category" name="category" aria-label="Default select example">
    <option selected disabled>Select a category</option>
    <?php
    include 'connection.php';
    $categories = $crud->get_category();
    echo var_dump($categories);
    ?>
    <?php foreach ($categories as $category): ?>
    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
    <?php endforeach; ?>
</select>