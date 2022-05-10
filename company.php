<?php

if (isset($_COOKIE['access_token']) && $_COOKIE['role'] == "company") {

    $access_token = $_COOKIE['access_token'];
    $companyId = $_COOKIE['company_id'];
    // Headers
    $headers = [
        "Authorization: Bearer " . $access_token . ""
    ];

    // CURL Company
    $companyUrl = "http://127.0.0.1:8000/api/v1/company/" . $companyId;
    $ch = curl_init($companyUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $companyData = json_decode($response);

    // CURL Industries
    $industriesUrl = "http://127.0.0.1:8000/api/v1/industries";
    $cUrlIndustries = curl_init($industriesUrl);
    curl_setopt($cUrlIndustries, CURLOPT_RETURNTRANSFER, true);
    $responseTwo = curl_exec($cUrlIndustries);
    curl_close($cUrlIndustries);
    $IndustriesData = json_decode($responseTwo);

    // CURL Jobs
    $jobsUrl = "http://127.0.0.1:8000/api/v1/company/jobs";
    $cUrlJobs = curl_init($jobsUrl);
    curl_setopt($cUrlJobs, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($cUrlJobs, CURLOPT_RETURNTRANSFER, true);
    $jobsResponse = curl_exec($cUrlJobs);
    curl_close($cUrlJobs);
    $JobsData = json_decode($jobsResponse);

    // print_r($JobsData);

    // Store Data in Variables
    $company = $companyData->company;
    $industries = $IndustriesData->industries;
    $jobs = $JobsData->jobs;
} elseif ($_COOKIE['role'] == "citizen") {
    header("Location: citizen.php");
    die();
} elseif ($_COOKIE['role'] == "staff") {
    header("Location: staff.php");
    die();
} else {
    header("Location: login.php");
    die();
}


$title = "User Dashboard";
include 'include/header.php';

?>



<div class="container my-5">
    <div class="row">
        <!-- User Profile Sidebar Starts -->
        <div class="col-md-3 col-sm-12 mb-4">
            <div class="bg-white rounded-3 shadow p-3">
                <!-- Profile Starts -->
                <div class="profile text-center">
                    <h4 class="fw-bold"><?php echo $company->company_name; ?></h4>
                    <h5 class="fw-bold"><?php echo $company->first_name . " " . $company->last_name; ?></h5>
                    <h6><?php echo $company->email; ?></h6>
                    <h6 class="text-uppercase"></h6>
                    <span class="fw-light">Member Since : <?php echo date("Y-m-d", strtotime($company->user_created_at)); ?></span>

                </div>
                <!-- Profile Ends -->

                <hr>

                <!-- Profile Sidebar Starts -->
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link link-dark active" aria-current="page" id="nav-profile">
                            <i class="bi bi-person"></i>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" id="nav-doc">
                            <i class="bi bi-files"></i>
                            Job Posts
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" id="nav-password">
                            <i class="bi bi-key"></i>
                            Change Password
                        </a>
                    </li>
                </ul>
                <!-- Profile Sidebar Ends -->

            </div>
        </div>
        <!-- User Profile Sidebar Ends -->

        <!-- User Dashboard Starts -->
        <div class="col-md-9 col-sm-12">
            <!-- Profile Starts -->
            <div class="bg-white rounded-3 shadow p-3" id="profile">
                <!-- Profile Status Starts -->
                <div class="px-3">
                    <h5 class="text-uppercase mb-3">Dashboard</h5>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            Profile Status
                        </div>
                        <div class="col-sm-3">
                            <?php if ($company->user_status == "active") { ?>
                                <i class="bi bi-check-circle-fill text-success fs-6"> Active</i>
                            <?php } else { ?>
                                <i class="bi bi-x-circle-fill text-danger fs-6"> Blocked</i>
                            <?php } ?>
                        </div>
                        <div class="col-sm-3">
                            Compnay Status
                        </div>
                        <div class="col-sm-3">
                            <?php if ($company->status == "verified") { ?>
                                <i class="bi bi-check-circle-fill text-success fs-6"> Verified</i>
                            <?php } elseif ($company->status == "unverified") { ?>
                                <i class="bi bi-x-circle-fill text-danger fs-6"> Unverified</i>
                            <?php } else { ?>
                                <i class="bi bi-x-circle-fill text-secondary fs-6"> Pending</i>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- Profile Status Ends -->

                <!-- Compnay Details Starts -->
                <div class="px-3">
                    <h5 class="text-uppercase mb-3">Company Information</h5>
                    <input type="text" id="companyId" required value="<?php echo $company->id; ?>" hidden>
                    <input type="text" id="accessToken" required value="<?php echo $access_token; ?>" hidden>
                    <form id="updateForm">
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Company</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="companyName" required value="<?php echo $company->company_name; ?>">
                            </div>
                            <label for="staticEmail" class="col-sm-2 col-form-label">Location</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="location" required value="<?php echo $company->location; ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Contact No</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="contactNo" required value="<?php echo $company->contact_no; ?>">
                            </div>
                            <label for="staticEmail" class="col-sm-2 col-form-label">Industry</label>
                            <div class="col-sm-4">
                                <select class="form-select mb-3" aria-label=".form-select industries" required id="industry">
                                    <?php foreach ($industries as $industry) { ?>
                                        <option <?php if ($industry->name == $company->industry_name) {
                                                    echo "selected";
                                                } ?> value="<?php echo $industry->id; ?>">
                                            <?php echo $industry->name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
                <!-- User Personal Details Ends -->
            </div>
            <!-- Profile Ends -->

            <!-- Documents Starts -->
            <div class="bg-white rounded-3 shadow p-3" id="documents">
                <h5 class="text-uppercase mb-3">Job Posts</h5>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Job ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Created Date</th>
                            <th scope="col">Application Deadline</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($jobs as $job) {
                            if ($job->company_id == $companyId) {
                        ?>
                                <tr>
                                    <td><?php echo $job->id; ?></td>
                                    <td><?php echo $job->title; ?></td>
                                    <td><?php echo date("Y-m-d", strtotime($job->created_at)); ?></td>
                                    <td><?php echo date("Y-m-d", strtotime($job->application_deadline)); ?></td>
                                    <td><?php echo $job->status; ?></td>
                                    <td>
                                        <a href="edit-job?jobId=<?php echo $job->id; ?>"><span class="text-info"><i class="bi bi-pencil-square"></i></span></a>
                                        <a href="delete-job?jobId=<?php echo $job->id; ?>"><span class="text-danger"><i class="bi bi-trash"></i></span></a>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <!-- Documents Ends -->

            <!-- Change Password Starts -->
            <div class="bg-white rounded-3 shadow p-3" id="change-password">
                <h5 class="text-uppercase mb-4">Change Password</h5>
                <div id="alert"></div>
                <form class="col-md-10 col-sm-12 mx-auto" id="changePassword">
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Current Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="currentPassword" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">New Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="newPassword" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Confirm Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="confirmPassword" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
            <!-- Change Password Ends -->
        </div>
        <!-- User Dashboard Ends -->
    </div>
</div>


<script>
    $("#documents").hide();
    $("#change-password").hide();

    // Profile
    $("#nav-profile").click(function() {
        $("#profile").show();
        $("#nav-profile").addClass("active");

        $("#change-password").hide();
        $("#nav-password").removeClass("active");

        $("#documents").hide();
        $("#nav-doc").removeClass("active");
    });

    // Job Posts
    $("#nav-doc").click(function() {
        $("#profile").hide();
        $("#nav-profile").removeClass("active");

        $("#change-password").hide();
        $("#nav-password").removeClass("active");

        $("#documents").show();
        $("#nav-doc").addClass("active");
    });

    // Chnage Password
    $("#nav-password").click(function() {
        $("#change-password").show();
        $("#nav-password").addClass("active");

        $("#profile").hide();
        $("#nav-profile").removeClass("active");

        $("#documents").hide();
        $("#nav-doc").removeClass("active");
    });



    var base_path = "http://127.0.0.1:8000/";
    var companyId = $("#companyId").val();
    var access_token = $("#accessToken").val();
    var update_url = base_path + "api/v1/company/" + companyId;
    var change_password_url = base_path + "api/v1/change-password";

    $(document).ready(function() {
        $("#updateForm").submit(function(event) {
            event.preventDefault();

            var formData = {
                companyName: $("#companyName").val(),
                location: $("#location").val(),
                industryId: $("#industry").val(),
                contactNo: $("#contactNo").val(),
            };

            $.ajax({
                type: "PUT",
                url: update_url,
                data: formData,
                dataType: "json",
                headers: {
                    "Authorization": `Bearer  ${access_token}`
                },
                encode: true,

            }).done(function(data) {
                location.reload();
            });
        });


        $("#changePassword").submit(function(event) {
            event.preventDefault();

            if ($("#newPassword").val() != $("#confirmPassword").val()) {
                var alertMessage = `<div class="alert alert-danger" role="alert">Confirm Password Mismatch</div>`;
                $("#alert").empty().append(alertMessage);
            } else {

                var formData = {
                    currentPassword: $("#currentPassword").val(),
                    newPassword: $("#newPassword").val(),
                };

                $.ajax({
                    type: "POST",
                    url: change_password_url,
                    data: formData,
                    dataType: "json",
                    headers: {
                        "Authorization": `Bearer  ${access_token}`
                    },
                    encode: true,

                }).done(function(data) {
                    var alertMessage = `<div class="alert alert-primary" role="alert">
                                            Password Changed Successfully
                                        </div>`;
                    $("#alert").empty().append(alertMessage);
                }).fail(function(response) {
                    var alertMessage = `<div class="alert alert-danger" role="alert">
                                            Current Password Error
                                        </div>`;
                    $("#alert").empty().append(alertMessage);
                });
            }
        });
    });
</script>
<?php include 'include/footer.php'; ?>