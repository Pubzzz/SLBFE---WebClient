<?php

if (isset($_COOKIE['access_token']) && $_COOKIE['role'] == "staff" && $_GET['nic']) {
    $access_token = $_COOKIE['access_token'];

    $nic = $_GET['nic'];
    $base_path = "http://127.0.0.1:8000/";

    // Headers
    $headers = [
        "Authorization: Bearer " . $access_token . ""
    ];

    $url = "http://127.0.0.1:8000/api/v1/citizen/" . $nic;

    $cUrl = curl_init($url);
    curl_setopt($cUrl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($cUrl);
    curl_close($cUrl);
    $data = json_decode($response);
    $citizen = $data->data;
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

$title = "Staff - Citizen";
include 'include/header.php';

?>

<!-- Check Citizen Starts -->
<div class="compliant-status my-5">
    <div class="col-md-8 mx-auto bg-white rounded-3 shadow pt-2 pb-4 px-5">
        <h2 class="fw-bolder text-center my-4"><?php echo $citizen->first_name . " " . $citizen->last_name; ?></h2>
        <hr>

        <div class="row px-3">
            <div class="col-3">
                <img src="<?php echo $base_path . $citizen->profile_image_path; ?>" width="120" height="120" class="rounded-circle my-2" alt="citizen profile image">
            </div>

            <div class="col-9">
                <div class="row">
                    <div class="col-md-3 col-sm-6 fw-bold">
                        User Status
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php if ($citizen->user_status == "active") { ?>
                            <span class="text-success"><?php echo $citizen->user_status; ?></span>
                        <?php } elseif ($citizen->user_status == "blocked") { ?>
                            <span class="text-danger"><?php echo $citizen->user_status; ?></span>
                        <?php } ?>
                    </div>
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Citizen
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php if ($citizen->citizen_verification_status == "verified") { ?>
                            <span class="text-success"><?php echo $citizen->citizen_verification_status; ?></span>
                        <?php } elseif ($citizen->citizen_verification_status == "unverified") { ?>
                            <span class="text-danger"><?php echo $citizen->citizen_verification_status; ?></span>
                        <?php } ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3 col-sm-6 fw-bold">
                        First Name
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php echo $citizen->first_name; ?>
                    </div>
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Last Name
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php echo $citizen->last_name; ?>
                    </div>
                    <div class="col-md-3 col-sm-6 fw-bold">
                        NIC
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php echo $citizen->nic; ?>
                    </div>
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Contact No
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php echo $citizen->mobile; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Email
                    </div>
                    <div class="col-md-9 col-sm-6">
                        <?php echo $citizen->email; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Passport No
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php echo $citizen->passport_no; ?>
                    </div>
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Expiry Date
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php echo $citizen->passport_expiry_date; ?>
                    </div>
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Profession
                    </div>
                    <div class="col-md-9 col-sm-6">
                        <?php echo $citizen->profession; ?>
                    </div>
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Industry
                    </div>
                    <div class="col-md-9 col-sm-6">
                        <?php echo $citizen->name; ?>
                    </div>
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Experience Level
                    </div>
                    <div class="col-md-9 col-sm-6">
                        <?php echo $citizen->experience_level; ?>
                    </div>
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Employee
                    </div>
                    <div class="col-md-9 col-sm-6">
                        <?php echo $citizen->employee_name; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-6 fw-bold">
                        Location
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php echo $citizen->location; ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-sm-6 fw-bold">
                        Address Line One
                    </div>
                    <div class="col-md-8 col-sm-6">
                        <?php echo $citizen->address_line_one; ?>
                    </div>
                    <div class="col-md-4 col-sm-6 fw-bold">
                        Address Line Two
                    </div>
                    <div class="col-md-8 col-sm-6">
                        <?php echo $citizen->address_line_two; ?>
                    </div>
                    <div class="col-md-4 col-sm-6 fw-bold">
                        City
                    </div>
                    <div class="col-md-8 col-sm-6">
                        <?php echo $citizen->city; ?>
                    </div>
                    <div class="col-md-4 col-sm-6 fw-bold">
                        Postal Code
                    </div>
                    <div class="col-md-8 col-sm-6">
                        <?php echo $citizen->postal_code; ?>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?php if ($citizen->user_status == "active") { ?>
                        <button class="btn btn-danger me-md-2" onclick="changeUserStatus(<?php echo $citizen->user_id; ?>, 'blocked')" type="button">Block</button>
                    <?php } elseif ($citizen->user_status == "blocked") { ?>
                        <button class="btn btn-primary me-md-2" onclick="changeUserStatus(<?php echo $citizen->user_id; ?>, 'active')" type="button">Unblock</button>
                    <?php } ?>

                    <?php if ($citizen->citizen_verification_status == "verified") { ?>
                        <button class="btn btn-secondary" onclick="changeCitizenStatus('<?php echo $citizen->nic; ?>', 'unverified')" type="button">Reset Status</button>
                    <?php } elseif ($citizen->citizen_verification_status == "unverified") { ?>
                        <button class="btn btn-success" onclick="changeCitizenStatus('<?php echo $citizen->nic; ?>', 'verified')" type="button">Verify</button>
                    <?php } ?>

                </div>
            </div>
        </div>
        <hr>
        <!-- Documents and Qualifications Starts -->
        <div id="documents">
            <h5 class="text-uppercase mb-3">Documents</h5>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Document Type</th>
                        <th scope="col">Verification Status</th>
                        <th scope="col">Uploaded Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="documentBody">
                </tbody>
            </table>

            <h5 class="text-uppercase mb-3 mt-5">Qualifications</h5>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Title</th>
                        <th scope="col">Field</th>
                        <th scope="col">School/ University</th>
                        <th scope="col">Verification Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="qBodyTwo">
                </tbody>
            </table>
        </div>
        <!-- Documents and Qualifications Ends -->

        <div class="mb-3 mt-4">
            <h5 class="text-uppercase mb-3">Delete Citizen</h5>
            <span class="text-danger">All associated data to this user will be deleted.</span>
            <div class="d-grid gap-2 col-6 mx-auto mt-3">
                <button class="btn btn-danger" onclick="deleteUser('<?php echo $citizen->nic; ?>')" type="button">Delete Citizen</button>
            </div>
        </div>

    </div>
</div>
<!-- Check Compliant Status Starts -->
<input type="text" id="accessToken" required value="<?php echo $access_token; ?>" hidden>
<input type="text" id="nic" required value="<?php echo $citizen->nic; ?>" hidden>


<script>
    var access_token = $("#accessToken").val();
    var nic = $("#nic").val();

    var base_path = "http://127.0.0.1:8000/api/v1/";
    var resource_path = "http://127.0.0.1:8000/";


    var documents_url = `${base_path}citizen/documents/${nic}`;
    var qualifications_url = `${base_path}citizen/qualifications/${nic}`;

    var document_status_url = `${base_path}citizen/document`;
    var qualification_status_url = `${base_path}citizen/qualification`;
    var user_status_url = `${base_path}user`;
    var citizen_status_url = `${base_path}citizen/verification`;
    var delete_user_url = `${base_path}citizen`;


    function changeUserStatus(userId, status) {
        event.preventDefault();

        $.ajax({
            type: "GET",
            url: `${user_status_url}/${userId}/${status}`,
            headers: {
                "Authorization": `Bearer  ${access_token}`
            },
        }).done(function(data) {
            location.reload();
        });
    }

    function changeCitizenStatus(nic, status) {
        event.preventDefault();

        $.ajax({
            type: "GET",
            url: `${citizen_status_url}/${nic}/${status}`,
            headers: {
                "Authorization": `Bearer  ${access_token}`
            },
        }).done(function(data) {
            location.reload();
        });
    }

    function changeDocumentStatus(documentId, status) {
        event.preventDefault();

        $.ajax({
            type: "GET",
            url: `${document_status_url}/${documentId}/${status}`,
            headers: {
                "Authorization": `Bearer  ${access_token}`
            },
        }).done(function(data) {
            location.reload();
        });
    }

    function changeQualificationStatus(qualificationId, status) {
        event.preventDefault();
        $.ajax({
            type: "GET",
            url: `${qualification_status_url}/${qualificationId}/${status}`,
            headers: {
                "Authorization": `Bearer  ${access_token}`
            },
        }).done(function(data) {
            location.reload();
        });
    }

    function deleteUser(nic) {
        event.preventDefault();

        $.ajax({
            type: "DELETE",
            url: `${delete_user_url}/${nic}`,
            headers: {
                "Authorization": `Bearer  ${access_token}`
            },
        }).done(function(data) {
            window.location.replace("staff.php");
        });
    }

    $.ajax({
        type: "GET",
        url: qualifications_url,
        dataType: "json",
        headers: {
            "Authorization": `Bearer  ${access_token}`
        },
        success: function(response) {
            let results = response.Qualifications;

            $.each(results, function(key, val) {

                if (val.status == "verified") {
                    var status = `
                    <div class="btn-group" role="group" aria-label="verified Qualifications">
                        <a href="${resource_path + val.file_path}" target="_blank" type="button" class="btn btn-primary btn-sm">View</a>
                        <button type="button" class="btn btn-secondary btn-sm" disabled>Accept</button>
                        <button onclick="changeQualificationStatus(${val.id}, 'unverified')" type="button" class="btn btn-danger btn-sm">Reject</button>
                    </div>`;
                } else if (val.status == "unverified") {
                    var status = `
                    <div class="btn-group" role="group" aria-label="unverified Qualifications">
                        <a href="${resource_path + val.file_path}" target="_blank" type="button" class="btn btn-primary btn-sm">View</a>
                        <button onclick="changeQualificationStatus(${val.id}, 'verified')" type="button" class="btn btn-success btn-sm">Accept</button>
                        <button onclick="changeQualificationStatus(${val.id}, 'unverified')" type="button" disabled class="btn btn-secondary btn-sm">Reject</button>
                    </div>`;
                } else {
                    var status = "No File";
                }

                var qVerifyRow = `
                <tr>
                    <th>${val.type}</th>
                    <td>${val.title}</td>
                    <td>${val.field}</td>
                    <td>${val.school_university}</td>
                    <td>${val.status}</td>
                    <td>${status}</td>
                </tr>
                `;

                $("#qBodyTwo").append(qVerifyRow);
            });
        }
    });

    $.ajax({
        type: "GET",
        url: documents_url,
        dataType: "json",
        headers: {
            "Authorization": `Bearer  ${access_token}`
        },
        success: function(response) {
            let results = response.documents;

            $.each(results, function(key, val) {
                // Created Date
                if (val.created_at == null) {
                    var created_at = "N/A";
                } else {
                    var created_at = val.created_at;
                }

                // Status
                if (val.status == "verified") {
                    var status = `
                    <div class="btn-group" role="group" aria-label="verified Qualifications">
                        <a href="${resource_path + val.file_path}" target="_blank" type="button" class="btn btn-primary btn-sm">View</a>
                        <button type="button" class="btn btn-secondary btn-sm" disabled>Accept</button>
                        <button type="button" onclick="changeDocumentStatus(${val.id}, 'unverified')" class="btn btn-danger btn-sm">Reject</button>
                    </div>`;

                } else if (val.status == "unverified") {
                    var status = `
                    <div class="btn-group" role="group" aria-label="unverified Qualifications">
                        <a href="${resource_path + val.file_path}" target="_blank" type="button" class="btn btn-primary btn-sm">View</a>
                        <button type="button" onclick="changeDocumentStatus(${val.id}, 'verified')" class="btn btn-success btn-sm">Accept</button>
                        <button type="button" onclick="changeDocumentStatus(${val.id}, 'unverified')" class="btn btn-danger btn-sm">Reject</button>
                    </div>`;

                } else {
                    var status = "No File";

                }

                var document = `
                    <tr>
                        <td>${val.type}</td>
                        <td>${val.status}</td>
                        <td>${created_at}</td>
                        <td>
                            ${status}
                        </td>
                    </tr>`;

                $("#documentBody").append(document);
            });
        }
    });
</script>

<?php include 'include/footer.php'; ?>