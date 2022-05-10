<?php

if (isset($_COOKIE['access_token']) && $_COOKIE['role'] == "staff" && $_GET['complaint']) {
    $access_token = $_COOKIE['access_token'];

    $complaintId = $_GET['complaint'];

    $url = "http://127.0.0.1:8000/api/v1/compliant/" . $complaintId;

    $cUrl = curl_init($url);
    curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($cUrl);
    curl_close($cUrl);
    $data = json_decode($response);
    $complaint = $data->complaint;
    $complaintStatus = $data->complaintStatus;

    // echo ($complaintId);

} elseif ($_COOKIE['role'] == "company") {
    header("Location: company.php");
    die();
} elseif ($_COOKIE['role'] == "citizen") {
    header("Location: citizen.php");
    die();
} else {
    header("Location: login.php");
    die();
}

$title = "Staff - Complaint";
include 'include/header.php';

?>

<!-- Check Complaint Status Starts -->
<div class="compliant-status my-5">
    <div class="col-md-6 mx-auto bg-white rounded-3 shadow pt-2 pb-4 px-5">
        <h2 class="fw-bolder text-center my-4">Complaint <span class="font-monospace text-danger fs-3" id="compliantResponseId">#<?php echo $complaint->id; ?></span></h2>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4 col-sm-6 fw-bold">
                        Name
                    </div>
                    <div class="col-md-8 col-sm-6" id="name">
                        <?php echo $complaint->first_name . " " . $complaint->last_name; ?>
                    </div>
                    <div class="col-md-4 col-sm-6 fw-bold">
                        Email
                    </div>
                    <div class="col-md-8 col-sm-6" id="email">
                        <?php echo $complaint->email; ?>
                    </div>
                    <div class="col-md-4 col-sm-6 fw-bold ">
                        Date
                    </div>
                    <div class="col-md-8 col-sm-6" id="createdDate">
                        <?php echo date("Y-m-d", strtotime($complaint->created_at)); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4 col-sm-6 fw-bold">
                        NIC
                    </div>
                    <div class="col-md-8 col-sm-6" id="nic">
                        <?php echo $complaint->nic; ?>
                    </div>
                    <div class="col-md-4 col-sm-6 fw-bold">
                        Contact
                    </div>
                    <div class="col-md-8 col-sm-6" id="contactNo">
                        <?php echo $complaint->contact_no; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-2 fw-bold">
                Reason
            </div>
            <div class="col-md-10" id="reason">
                <?php echo $complaint->reason; ?>
            </div>
        </div>

        <div class="row mt-2">
            <h6 class="fw-bold">Description</h6>
            <p class="text-wrap" id="compliantDescription"><?php echo $complaint->message; ?></p>
        </div>

        <hr>
        <h5 class="fw-bold mb-2">Status</h5>
        <div class="row px-4" id="statusTable">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Comments</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php foreach ($complaintStatus as $status) { ?>
                        <tr>
                            <td><?php echo date("Y-m-d", strtotime($status->created_at)); ?></td>
                            <td><?php echo $status->status; ?></td>
                            <td><?php echo $status->comments; ?></td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
        <hr>
        <h5 class="fw-bold my-2">Add New Status</h5>
        <div class="row px-4">
            <form id="updateStatus">
                <div class="mb-3">
                    <label for="newStatus" class="form-label">Status</label>
                    <input type="text" class="form-control form-control-sm" id="newStatus">
                </div>
                <div class="mb-3">
                    <label for="newComment" class="form-label">Comments</label>
                    <textarea class="form-control form-control-sm" id="newComment" rows="2"></textarea>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Check Compliant Status Starts -->
<input type="text" id="accessToken" required value="<?php echo $access_token; ?>" hidden>
<input type="text" id="complaintId" required value="<?php echo $complaintId; ?>" hidden>

<script>
    var access_token = $("#accessToken").val();
    var complaintId = $("#complaintId").val();


    var base_path = "http://127.0.0.1:8000/api/v1/";
    var url = `${base_path}compliant/status/${complaintId}`;

    $(document).ready(function() {
        $("#updateStatus").submit(function(event) {
            event.preventDefault();

            var formData = {
                status: $("#newStatus").val(),
                comments: $("#newComment").val(),
            };

            $.ajax({
                type: "POST",
                url: url,
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
    });
</script>

<?php include 'include/footer.php'; ?>