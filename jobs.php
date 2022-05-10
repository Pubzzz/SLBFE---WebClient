<?php

if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

if (isset($_GET['industryId'])) {
    $getIndustryId= $_GET['industryId'];
    $jobsUrl = "http://127.0.0.1:8000/api/v1/jobs?industryId=" . $getIndustryId . "&page=" . $currentPage;
} else {
    $jobsUrl = "http://127.0.0.1:8000/api/v1/jobs?page=" . $currentPage;
}

$title = "Search Jobs";
include 'include/header.php';

// CURL Jobs
$cUrlJobs = curl_init($jobsUrl);
curl_setopt($cUrlJobs, CURLOPT_RETURNTRANSFER, true);
$jobsResponse = curl_exec($cUrlJobs);
curl_close($cUrlJobs);
$JobsData = json_decode($jobsResponse);

// CURL Industries
$industriesUrl = "http://127.0.0.1:8000/api/v1/industries";
$cUrlIndustries = curl_init($industriesUrl);
curl_setopt($cUrlIndustries, CURLOPT_RETURNTRANSFER, true);
$responseTwo = curl_exec($cUrlIndustries);
curl_close($cUrlIndustries);
$IndustriesData = json_decode($responseTwo);

$industries = $IndustriesData->industries;


$data = $JobsData->jobs;
$jobs = $data->data;

?>

<div class="row my-4 g-0">
    <div class="col-md-10 col-sm-12 mx-auto">
        <!-- Search Bar Starts -->
        <div class="bg-white rounded-3 shadow px-5">
            <h2 class="fw-bolder py-4 text-center">Find Jobs</h2>
        </div>
        <!-- Search Bar Ends -->

        <div class="row mt-4 mb-4">

            <!-- Job Filter By Starts -->
            <div class="col-md-4 col-sm-12">
                <div class="bg-white rounded-3 shadow p-3">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="mb-3">Filters</h4>
                        </div>
                        <div class="col-6">

                        </div>
                    </div>

                    <h6 class="fw-bolder">Industry</h6>
                    <select class="form-select mb-3" aria-label=".form-select industries" id="industry">
                        <?php foreach ($industries as $industry) { ?>
                            <option value="jobs.php?industryId=<?php echo $industry->id; ?>">
                                <?php echo $industry->name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- Job Filter By Ends -->



            <!-- Job Listing Starts -->
            <div class="col-md-8 col-sm-12">
                <div class="bg-white rounded-3 shadow">
                    <!-- Search Results Count Starts -->
                    <div class="search-result-info pt-3 px-3">
                        <div class="row">
                            <div class="col-8">
                                <?php if (isset($search)) { ?>
                                    <h5>Search Results for <span Class="fst-italic">"Software Development in USA"</span></h5>
                                <?php } ?>
                            </div>
                            <div class="col-4">
                                <h5 class="text-end"><?php echo $data->total; ?> Jobs Found</h5>
                            </div>
                        </div>
                    </div>
                    <!-- Search Results Count Ends -->




                    <?php foreach ($jobs as $job) { ?>
                        <!-- Single Job Starts -->
                        <div class="job p-3 mb-1">
                            <h5 class="fw-bold"><?php echo $job->title; ?></h5>
                            <p class="text-wrap"><?php echo $job->description; ?></p>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <h6><span class="fw-bold">Location : </span><?php echo $job->location; ?> </h6>
                                    <h6><span class="fw-bold">Application Deadline : </span><?php echo $job->application_deadline; ?> </h6>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h6><span class="fw-bold">Comapny : </span><?php echo $job->name; ?> </h6>
                                    <h6><span class="fw-bold">Email : </span><?php echo $job->email; ?></h6>
                                </div>
                            </div>
                        </div>
                        <!-- Single Job Ends -->
                        <hr>
                    <?php } ?>


                    <!-- <hr> -->

                </div>

                <br>
                <!-- Pagination Starts -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <?php
                        $cp = $currentPage;
                        if ($currentPage > 1) {
                            $prePage = --$cp;
                            $preStatus = "";
                        } else {
                            $prePage = "#";
                            $preStatus = "disabled";
                        }

                        $lastPage = $data->last_page;
                        ?>
                        <li class="page-item <?php echo $preStatus; ?>">
                            <a class="page-link" href="jobs.php?page=<?php echo $prePage; ?>" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $lastPage; $i++) {
                        ?>
                            <li class="page-item"><a class="page-link" href="jobs.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php } ?>

                        <?php

                        if ($currentPage < $lastPage) {
                            $nextPage = ++$currentPage;
                            $nextStatus = "";
                        } else {
                            $nextPage = "#";
                            $nextStatus = "disabled";
                        } ?>
                        <li class="page-item <?php echo $nextStatus; ?>">
                            <a class="page-link" href="jobs.php?page=<?php echo $nextPage; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
                <!-- Pagination Ends -->
            </div>
            <!-- Job Listing Ends -->

        </div>
    </div>
</div>

<script>
    $(function() {
        $('#industry').on('change', function() {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });
</script>

<?php include 'include/footer.php'; ?>