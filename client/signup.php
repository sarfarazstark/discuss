<div class="container col-sm-6 offset-sm-3 my-5 px-5">
    <h3 class="text-center">Sign Up</h3>
    <form class="mt-5" method="post" action="server/requests.php">
        <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert"><?= $_GET['error'] ?></div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="mb-3">
            <small>By signing up you accept the terms and conditions.</small>
        </div>
        <button type="submit" class="btn btn-primary" name="signup">Submit</button>
    </form>
</div>