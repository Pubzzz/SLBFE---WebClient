<?php

if (isset($_COOKIE['access_token']) && $_COOKIE['role'] == "company") {

    if (!isset($_GET['jobId'])) {
        header("Location: post-job.php");
        die();
    }

    $jobId = $_GET['jobId'];
    $access_token = $_COOKIE['access_token'];

    // CURL Company
    $jobUrl = "http://127.0.0.1:8000/api/v1/job/" . $jobId;
    $ch = curl_init($jobUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $jobData = json_decode($response);
    $job = $jobData->job;
} else {
    header("Location: login.php");
    die();
}

// CURL Industries
$industriesUrl = "http://127.0.0.1:8000/api/v1/industries";
$cUrlIndustries = curl_init($industriesUrl);
curl_setopt($cUrlIndustries, CURLOPT_RETURNTRANSFER, true);
$responseTwo = curl_exec($cUrlIndustries);
curl_close($cUrlIndustries);
$IndustriesData = json_decode($responseTwo);

$industries = $IndustriesData->industries;

$title = "Edit Job";
include 'include/header.php';

?>

<div class="row my-5 g-0">
    <div class="col-md-6 col-sm-12 mx-auto bg-white rounded-3 shadow px-5">
        <h2 class="fw-bolder text-center my-4">Edit Job</h2>
        <input type="text" id="accessToken" required value="<?php echo $access_token; ?>" hidden>
        <input type="text" id="jobId" required value="<?php echo $job->id; ?>" hidden>

        <!-- Alert Message  -->
        <div id="alert-message"></div>
        <form id="form">
            <div class="row my-4 g-1">
                <div class="col-md-12">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="title" value="<?php echo $job->title; ?>" maxlength="60" required>
                        <label for="floatingInput">Job Title</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2">
                        <select class="form-select" aria-label="Floating label select" required id="industry">
                            <?php foreach ($industries as $industry) { ?>
                                <option <?php if ($industry->id == $job->industry_id) {
                                            echo "selected";
                                        } ?> value="<?php echo $industry->id; ?>">
                                    <?php echo $industry->name; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label for="floatingSelect">Category</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-2">
                        <input type="date" class="form-control" id="application_deadline" value="<?php echo $job->application_deadline; ?>" required>
                        <label for="floatingInput">Application Deadline</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-2">
                        <textarea class="form-control" placeholder="Leave a comment here" id="description" style="height: 150px" required><?php echo $job->description; ?></textarea>
                        <label for="floatingTextarea2">Job Details</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-dark" type="submit">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var access_token = $("#accessToken").val();
    var job_id = $("#jobId").val();
    var put_job_url = `http://127.0.0.1:8000/api/v1/job/${job_id}`;

    $(document).ready(function() {
        // Put Job Form
        $("#form").submit(function(event) {
            event.preventDefault();

            // Form Data
            var formData = {
                title: $("#title").val(),
                description: $("#description").val(),
                industryId: $("#industry").val(),
                applicationDeadline: $("#application_deadline").val(),
            };

            $.ajax({
                type: "PUT",
                url: put_job_url,
                data: formData,
                dataType: "json",
                headers: {
                    "Authorization": `Bearer  ${access_token}`
                },
                encode: true,
            }).done(function(data) {
                var successMsg = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Job Posted Successfully Updated.</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`;

                $("#alert-message").append(successMsg);
            });

        });
    });
</script>

<?php include 'include/footer.php'; ?>