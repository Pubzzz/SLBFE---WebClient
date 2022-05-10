<?php

if (isset($_COOKIE['access_token']) && $_COOKIE['role'] == "company") {

    $access_token = $_COOKIE['access_token'];
    $companyId = $_COOKIE['company_id'];
    // Headers
    $headers = [
        "Authorization: Bearer " . $access_token . ""
    ];

    if (isset($_GET['page'])) {
        $currentPage = $_GET['page'];
    } else {
        $currentPage = 1;
    }

    if (isset($_GET['qualification'])) {
        $qualificationId = $_GET['qualification'];
        $url = "http://127.0.0.1:8000/api/v1/citizens/qualification/find?qualification=" . $qualificationId . "&page=" . $currentPage;
    } elseif (isset($_GET['industry'])) {
        $getIndustryId = $_GET['industry'];
        $url = "http://127.0.0.1:8000/api/v1/citizens/industry/find?industry=" . $getIndustryId . "&page=" . $currentPage;
    } else {
        $url = "http://127.0.0.1:8000/api/v1/citizens?page=" . $currentPage;
    }

    // CURL Citizens
    $citizenCURL = curl_init($url);
    curl_setopt($citizenCURL, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($citizenCURL, CURLOPT_HTTPHEADER, $headers);
    $citizenResponse = curl_exec($citizenCURL);
    curl_close($citizenCURL);
    $citizenData = json_decode($citizenResponse);

    // CURL Industries
    $industriesUrl = "http://127.0.0.1:8000/api/v1/industries";
    $cUrlIndustries = curl_init($industriesUrl);
    curl_setopt($cUrlIndustries, CURLOPT_RETURNTRANSFER, true);
    $responseTwo = curl_exec($cUrlIndustries);
    curl_close($cUrlIndustries);
    $IndustriesData = json_decode($responseTwo);

    $industries = $IndustriesData->industries;

    $data = $citizenData->data;
    $citizens = $citizenData->data->data;
    // print_r($citizen);

    $resourcesUrl = "http://127.0.0.1:8000/";
} else {
    header("Location: login.php");
    die();
}


$title = "Search Candidates";
include 'include/header.php';

?>

<div class="row my-4 g-0">
    <div class="col-md-10 col-sm-12 mx-auto">
        <!-- Search Bar Starts -->
        <div class="bg-white rounded-3 shadow px-5">
            <h2 class="fw-bolder py-4 text-center">Find Candidates</h2>
        </div>
        <!-- Search Bar Ends -->

        <div class="row mt-4">
            <!-- Candidates Filters Starts -->
            <div class="col-md-4 col-sm-12">
                <div class="bg-white rounded-3 shadow p-3">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h4>Filters</h4>
                        </div>
                        <div class="col-6">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-outline-dark me-md-2 btn-sm" type="button">Reset All</button>
                            </div>
                        </div>
                    </div>
                    <div class="industry mb-3">
                        <h6 class="fw-bolder">Industry</h6>
                        <select class="form-select mb-3" aria-label=".form-select industries" id="industry">
                            <option selected>Select Industry</option>

                            <?php foreach ($industries as $industry) { ?>
                                <option value="?industry=<?php echo $industry->id; ?>">
                                    <?php echo $industry->name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="industry mb-3">
                        <h6 class="fw-bolder">Highest Acadamic Qualification</h6>
                        <select class="form-select form-select-sm mb-3" aria-label="Default select example" id="qualification">
                            <option selected>Select Qualification</option>
                            <option value="?qualification=5">Master's Degree</option>
                            <option value="?qualification=4">Bachelor's Degree</option>
                            <option value="?qualification=3">HND/ Advanced Diploma</option>
                            <option value="?qualification=2">Certificate</option>
                            <option value="?qualification=1">High School Diploma</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Candidates Filters Ends -->

            <!-- Candidates Starts -->
            <div class="col-md-8 col-sm-12">
                <?php foreach ($citizens as $citizen) { ?>
                    <!-- Single Candidate Starts -->
                    <div class="candidate bg-white rounded-3 shadow p-3 mb-1">
                        <div class="row">
                            <div class="col-2 text-center mt-3">
                                <img src="<?php echo $resourcesUrl . $citizen->profile_image_path; ?>" width="100" height="100" class="rounded-circle" alt="...">
                            </div>
                            <div class="col-10">
                                <h5 class="fw-bold mb-0"></h5>
                                <h6>Software Developer</h6>
                                <h6><span class="fw-bold">Industry : </span><?php echo $citizen->name; ?></h6>
                                <h6><span class="fw-bold">Experiance : </span><span class="text-success"><?php echo $citizen->experience_level; ?></span></h6>
                                <h6><span class="fw-bold">Email : </span><?php echo $citizen->email; ?></h6>
                            </div>
                        </div>
                    </div>
                    <!-- Single Candidate Ends -->
                <?php } ?>

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
            <!-- Candidates Ends -->
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

    $(function() {
        $('#qualification').on('change', function() {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });
</script>

<?php include 'include/footer.php'; ?>