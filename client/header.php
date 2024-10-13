<nav class="container-fluid navbar navbar-expand-lg bg-body-tertiary  d-flex justify-content-center">
    <div class="container-sm mx-4">
        <a class="navbar-brand" href="/discuss"><img src="./public/logo.png" alt="logo" height="40"></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="col-12 navbar-nav mb-2 mb-lg-0 gap-3">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/discuss">Home</a>
                </li>
                <li class="nav-item me-auto">
                    <a class="nav-link" href="?latest">Latest Questions</a>
                </li>

                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <div class="dropdown-center">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Hello <?= $_SESSION['username'] ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-lg-end  text-center">
                                <li class="dropdown-item ">
                                    <a class="btn btn-primary" href="?ask">Post your question</a>
                                </li>
                                <li><a class="dropdown-item fw-bold" href="?userid=<?= $_SESSION['user_id'] ?>">My
                                        Questions</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="./server/requests.php?logout=true">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="?login=true">Login </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="?signup=true">Sign Up</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <form class="input-group">
                        <input type="text" class="form-control" placeholder="Search question..." name="search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php
date_default_timezone_set('Asia/Kolkata');
function timeAgo($datetime, $full = false)
{
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    // Calculate the total number of days
    $totalDays = $diff->y * 365 + $diff->m * 30 + $diff->d; // Rough estimation
    $weeks = floor($totalDays / 7);
    $days = $totalDays % 7; // Remaining days after weeks

    $string = [
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];

    // Prepare the output based on the calculated values
    $output = [];
    if ($diff->y) {
        $output[] = $diff->y . ' ' . $string['y'] . ($diff->y > 1 ? 's' : '');
    }
    if ($diff->m) {
        $output[] = $diff->m . ' ' . $string['m'] . ($diff->m > 1 ? 's' : '');
    }
    if ($weeks) {
        $output[] = $weeks . ' ' . $string['w'] . ($weeks > 1 ? 's' : '');
    }
    if ($days) {
        $output[] = $days . ' ' . $string['d'] . ($days > 1 ? 's' : '');
    }
    if ($diff->h) {
        $output[] = $diff->h . ' ' . $string['h'] . ($diff->h > 1 ? 's' : '');
    }
    if ($diff->i) {
        $output[] = $diff->i . ' ' . $string['i'] . ($diff->i > 1 ? 's' : '');
    }
    if ($diff->s) {
        $output[] = $diff->s . ' ' . $string['s'] . ($diff->s > 1 ? 's' : '');
    }

    if (!$full) {
        $output = array_slice($output, 0, 1);
    }

    return $output ? implode(', ', $output) . ' ago' : 'just now';
}
?>
