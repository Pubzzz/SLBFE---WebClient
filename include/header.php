<?php

if (isset($_COOKIE['access_token'])) {
    $isLogin = True;
} else {
    $isLogin = false;
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" integrity="sha384-ejwKkLla8gPP8t2u0eQyL0Q/4ItcnyveF505U0NIobD/SMsNyXrLti6CWaD0L52l" crossorigin="anonymous">

    <!-- JQuery -->
    <script src="js/jquery-3.6.0.min.js"></script>

    <title>SLBFE - <?php echo $title; ?></title>
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header Starts -->
    <div class="bg-white">
        <header class="container d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3">
            <a href="/" class="d-flex align-items-center col-md-4 mb-2 mb-md-0 text-dark text-decoration-none fs-4 fw-bolder text-uppercase">
                Sri Lanka Bureau of Foreign Employment (SLBFE)
            </a>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle link-dark" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Our Services
                    </a>
                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li>
                            <h6 class="dropdown-header">For Citizens</h6>
                        </li>
                        <li><a class="dropdown-item" href="jobs.php">Find a Job</a></li>
                        <li><a class="dropdown-item" href="complaint.php">Make a Complaint</a></li>
                        <li><a class="dropdown-item" href="track-complaint.php">Track Complaint</a></li>
                        <li>
                            <h6 class="dropdown-header">For Recruiters</h6>
                        </li>
                        <li><a class="dropdown-item" href="candidates.php">Search for Candidates</a></li>
                        <li><a class="dropdown-item" href="post-job.php">Post a Job</a></li>
                    </ul>
                </li>
                <li><a href="about.php" class="nav-link px-2 link-dark">About</a></li>
                <li><a href="contact-us.php" class="nav-link px-2 link-dark">Contact Us</a></li>
            </ul>
            <div class="col-md-3 text-end">
                <?php if ($isLogin == true) {
                    if (isset($_COOKIE['role'])) {
                        $userRole = $_COOKIE['role'];

                        switch ($userRole) {
                            case "citizen":
                                $myAccount = "citizen.php";
                                break;
                            case "company":
                                $myAccount = "company.php";
                                break;
                            default:
                                $myAccount = "staff.php";
                        }
                    }
                ?>
                    <a href="<?php echo $myAccount ?>" type="button" class="btn btn-outline-dark me-2 btn-sm">My Account</a>
                    <a href="logout.php" type="button" class="btn btn-dark btn-sm">Logout</a>
                <?php } else { ?>
                    <a href="login.php" type="button" class="btn btn-outline-dark me-2 btn-sm">Login</a>
                    <a href="register.php" type="button" class="btn btn-dark btn-sm">Register</a>
                <?php } ?>
            </div>
        </header>

    </div>
    <!-- Header Ends -->