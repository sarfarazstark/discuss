<div class="container col-sm-6 offset-sm-3 my-5 px-5">
    <h3>Login</h3>
    <form class="mt-5" method="post" action="server/requests.php">
        <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success" role="alert"><?= $_GET['message'] ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert"><?= $_GET['error'] ?></div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Submit</button>
    </form>
</div>