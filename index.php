<?php

$title = "Home";
include 'include/header.php';

?>

<!-- Carousel Starts -->
<div id="carouselExampleIndicators" class="carousel slide pt-0" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/banner-test.jpg" class="d-block w-100" height="400" alt="...">
        </div>
        <div class="carousel-item">
            <img src="images/banner-2.jpg" class="d-block w-100" height="400" alt="...">
        </div>
        <div class="carousel-item">
            <img src="images/banner-test.jpg" class="d-block w-100" height="400" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- Carousel Ends -->

<div class="row my-4 mx-3">
    <div class="col-sm-12 col-md-8">
        <h2 class="text-center mb-3 fw-bold">Featured Jobs</h2>
        <div class="featured-job">

        </div>
        <div class="d-grid gap-2 col-4 mx-auto mt-4">
            <a type="button" href="jobs.php" class="btn btn-outline-secondary">Browse All Jobs</a>
        </div>

    </div>
    <div class="col-sm-12 col-md-4">
        <h2 class="text-center mb-3 fw-bold">News & Events</h2>

        <div class="bg-white rounded-3 shadow pt-4 px-4">
            <!-- Single News & Event Starts -->
            <div class="row mt-2">
                <h6 class="fw-bold">Sample Data</h6>
                <div class="col-4 mt-2">
                    <img src="images/news-1.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-8">
                    <p class="text-wrap">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                        ut labore et dolore magna aliqua. Ut enim ad minim veniam
                    </p>
                </div>
                <hr>
            </div>
            <!-- Single News & Event Ends -->

            <!-- Single News & Event Starts -->
            <div class="row mt-2">
                <h6 class="fw-bold">Sample Data</h6>
                <div class="col-4 mt-2">
                    <img src="images/news-1.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-8">
                    <p class="text-wrap">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                        ut labore et dolore magna aliqua. Ut enim ad minim veniam
                    </p>
                </div>
                <hr>
            </div>
            <!-- Single News & Event Ends -->
        </div>
    </div>
</div>

<script>
    var jobs_url = 'http://127.0.0.1:8000/api/v1/jobs';

    // Featured Jobs
    $.ajax({
        type: "GET",
        url: jobs_url,
        dataType: "json",
        success: function(response) {
            let results = response.jobs.data;
            $.each(results.slice(0, 4), function(key, val) {

                var singleJob = `<!-- Single Featured Job Starts -->
        <div class="bg-white rounded-3 shadow p-4 mb-2">
            <h5 class="fw-bold">${val.title}
            </h5>
            <p class="text-wrap">${val.description}</p>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h6><span class="fw-bold">Location : </span>${val.location}</h6>
                    <h6><span class="fw-bold">Application Deadline : </span>${val.application_deadline} </h6>
                </div>
                <div class="col-md-6 col-sm-12">
                    <h6><span class="fw-bold">Comapny : </span>${val.name} </h6>
                    <h6><span class="fw-bold">Email : </span>${val.email}</h6>
                </div>
            </div>
        </div>
        <!-- Single Featured Job Ends -->`;
                $(".featured-job").append(singleJob);
            });
        }
    });
</script>

<?php include 'include/footer.php'; ?>