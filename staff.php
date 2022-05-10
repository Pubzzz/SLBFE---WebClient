<?php

if (isset($_COOKIE['access_token']) && $_COOKIE['role'] == "staff") {
    $access_token = $_COOKIE['access_token'];

    // Headers
    $headers = [
        "Authorization: Bearer " . $access_token . ""
    ];

    $staff_url = "http://127.0.0.1:8000/api/v1/staff";
    $compliants_url = "http://127.0.0.1:8000/api/v1/compliants";
    $citizens_url = "http://127.0.0.1:8000/api/v1/citizens";
    $companies_url = "http://127.0.0.1:8000/api/v1/companies";

    // Staff Profile Data
    $staff_cUrl = curl_init($staff_url);
    curl_setopt($staff_cUrl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($staff_cUrl, CURLOPT_RETURNTRANSFER, true);
    $staff_response = curl_exec($staff_cUrl);
    curl_close($staff_cUrl);
    $staff_data = json_decode($staff_response);
    $staff = $staff_data->data;

    // User Compliants Data
    $compliants_cUrl = curl_init($compliants_url);
    curl_setopt($compliants_cUrl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($compliants_cUrl, CURLOPT_RETURNTRANSFER, true);
    $compliants_response = curl_exec($compliants_cUrl);
    curl_close($compliants_cUrl);
    $compliants_data = json_decode($compliants_response);
    $compliants = $compliants_data->data;

    // Registered Citizens Data
    $citizens_cUrl = curl_init($citizens_url);
    curl_setopt($citizens_cUrl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($citizens_cUrl, CURLOPT_RETURNTRANSFER, true);
    $citizens_response = curl_exec($citizens_cUrl);
    curl_close($citizens_cUrl);
    $citizens_data = json_decode($citizens_response);
    $citizens = $citizens_data->data->data;

    // Companies Data
    $companies_cUrl = curl_init($companies_url);
    curl_setopt($companies_cUrl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($companies_cUrl, CURLOPT_RETURNTRANSFER, true);
    $companies_response = curl_exec($companies_cUrl);
    curl_close($companies_cUrl);
    $companies_data = json_decode($companies_response);
    $companies = $companies_data->companies;
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

$title = "Staff Dashboard";
include 'include/header.php';

?>

<script>
    $(document).ready(function() {
        $("#compliant").hide();
        $("#citizens").hide();
        $("#companies").hide();

        // Profile
        $("#nav-profile").click(function() {
            $("#profile").show();
            $("#nav-profile").addClass("active");

            $("#compliant").hide();
            $("#nav-complaint").removeClass("active");

            $("#citizens").hide();
            $("#nav-citizens").removeClass("active");

            $("#companies").hide();
            $("#nav-companies").removeClass("active");
        });

        $("#nav-complaint").click(function() {
            $("#profile").hide();
            $("#nav-profile").removeClass("active");

            $("#compliant").show();
            $("#nav-complaint").addClass("active");

            $("#citizens").hide();
            $("#nav-citizens").removeClass("active");

            $("#companies").hide();
            $("#nav-companies").removeClass("active");
        });

        $("#nav-citizens").click(function() {
            $("#profile").hide();
            $("#nav-profile").removeClass("active");

            $("#compliant").hide();
            $("#nav-complaint").removeClass("active");

            $("#citizens").show();
            $("#nav-citizens").addClass("active");

            $("#companies").hide();
            $("#nav-companies").removeClass("active");
        });

        $("#nav-companies").click(function() {
            $("#profile").hide();
            $("#nav-profile").removeClass("active");

            $("#compliant").hide();
            $("#nav-complaint").removeClass("active");

            $("#citizens").hide();
            $("#nav-citizens").removeClass("active");

            $("#companies").show();
            $("#nav-companies").addClass("active");
        });
    });
</script>

<!-- Citizens Contact Details Modal Starts -->
<div class="modal fade" id="contactDetails" tabindex="-1" aria-labelledby="contactDetails" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Citizen Contact Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="citizenDetailsModalBody">

            </div>
        </div>
    </div>
</div>
<!-- Citizens Contact Details Modal Ends -->

<div class="container my-5">
    <div class="row">
        <!-- User Profile Sidebar Starts -->
        <div class="col-md-3 col-sm-12 mb-4">
            <div class="bg-white rounded-3 shadow p-3">
                <!-- Profile Starts -->
                <div class="profile text-center">
                    <h5 class="fw-bold"><?php echo $staff->first_name . " " . $staff->last_name; ?></h5>
                    <h6 class="text-uppercase">Staff Member</h6>
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
                        <a href="#" class="nav-link link-dark" id="nav-complaint">
                            <i class="bi bi-files"></i>
                            Compliants
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" id="nav-citizens">
                            <i class="bi bi-people-fill"></i>
                            Citizens
                        </a>
                    </li>

                    <li>
                        <a href="#" class="nav-link link-dark" id="nav-companies">
                            <i class="bi bi-building"></i>
                            Companies
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
                <!-- Personal Details Starts -->
                <div class="px-3">
                    <h5 class="text-uppercase mb-3">Personal Information</h5>
                    <form id="updateStaffForm">
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">First Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="staffFirstName" value="<?php echo $staff->first_name; ?>">
                            </div>
                            <label for="staticEmail" class="col-sm-2 col-form-label">Last Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="staffLastName" value="<?php echo $staff->last_name; ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" readonly id="staffEmail" value="<?php echo $staff->email; ?>">
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                    <hr>
                    <!-- Change Password Starts -->
                    <div>
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
                <!-- Personal Details Ends -->
            </div>
            <!-- Profile Ends -->

            <!-- Compliants  Starts -->
            <div class="bg-white rounded-3 shadow p-3" id="compliant">
                <h5 class="text-uppercase mb-3">Compliants</h5>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Compliant ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Contact No</th>
                            <th scope="col">Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($compliants as $compliant) { ?>
                            <tr>
                                <td><?php echo $compliant->id; ?></td>
                                <td><?php echo $compliant->first_name . " " . $compliant->last_name; ?></td>
                                <td><?php echo $compliant->reason; ?></td>
                                <td><?php echo $compliant->contact_no; ?></td>
                                <td><?php echo date("Y-m-d", strtotime($compliant->created_at)); ?></td>
                                <td>
                                    <a type="button" href="staff-complaint.php?complaint=<?php echo $compliant->id; ?>" class="btn btn-primary btn-sm">Update</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- Compliants Ends -->


            <!-- Citizens Starts -->
            <div class="bg-white rounded-3 shadow p-3" id="citizens">
                <h5 class="text-uppercase mb-3">Citizens</h5>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">User ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">User Status</th>
                            <th scope="col">Profile Status</th>
                            <th scope="col">NIC</th>
                            <th scope="col">Created Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($citizens as $citizen) { ?>
                            <tr>
                                <td><?php echo $citizen->user_id; ?></td>
                                <td><?php echo $citizen->first_name . " " . $citizen->last_name; ?></td>
                                <td><?php echo $citizen->email; ?></td>
                                <td><?php echo $citizen->user_status; ?></td>
                                <td><?php echo $citizen->citizen_verification_status; ?></td>
                                <td><?php echo $citizen->nic; ?></td>
                                <td><?php echo date("Y-m-d", strtotime($citizen->user_created_at)); ?></td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary btn-sm me-md-2" onclick="viewContactDetails('<?php echo $citizen->nic; ?>')" data-bs-toggle="modal" data-bs-target="#contactDetails" type="button">Contact</button>
                                        <a type="button" class="btn btn-primary btn-sm" href="staff-citizen.php?nic=<?php echo $citizen->nic; ?>">View</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- Citizens Ends -->

            <!-- Companies Starts -->
            <div class="bg-white rounded-3 shadow p-3" id="companies">
                <h5 class="text-uppercase mb-3">Companies</h5>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Company ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Location</th>
                            <th scope="col">Contact No</th>
                            <th scope="col">Industry</th>
                            <th scope="col">Status</th>
                            <th scope="col">Change Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($companies as $company) { ?>
                            <tr>
                                <td><?php echo $company->id; ?></td>
                                <td><?php echo $company->company_name; ?></td>
                                <td><?php echo $company->location; ?></td>
                                <td><?php echo $company->contact_no; ?></td>
                                <td><?php echo $company->name; ?></td>
                                <td><?php echo $company->status; ?></td>
                                <td>
                                    <?php if ($company->status == "unverified") { ?>
                                        <button type="button" onclick="changeCompanyStatus(<?php echo $company->id; ?>, 'verified')" class="btn btn-success btn-sm">Verify</button>
                                    <?php } elseif ($company->status == "verified") { ?>
                                        <button type="button" onclick="changeCompanyStatus(<?php echo $company->id; ?>, 'unverified')" class="btn btn-secondary btn-sm">Unverified</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- Companies Ends -->
        </div>
        <!-- User Dashboard Ends -->
    </div>
</div>

<input type="text" id="accessToken" required value="<?php echo $access_token; ?>" hidden>


<script>
    var access_token = $("#accessToken").val();

    var base_path = "http://127.0.0.1:8000/api/v1/";
    var resource_path = "http://127.0.0.1:8000/";

    var change_password_url = `${base_path}change-password`;
    var update_staff_url = `${base_path}staff`;
    var company_status_update_url = `${base_path}company/`;

    function changeCompanyStatus(companyId, status) {
        event.preventDefault();

        $.ajax({
            type: "PUT",
            url: `${company_status_update_url}${companyId}/${status}`,
            headers: {
                "Authorization": `Bearer  ${access_token}`
            },
        }).done(function(data) {
            location.reload();
        });
    }

    function viewContactDetails(nic) {
        event.preventDefault();

        $.ajax({
            type: "GET",
            url: `${base_path}citizens/${nic}/contacts`,
            headers: {
                "Authorization": `Bearer  ${access_token}`
            },
        }).done(function(data) {
            var citizen = data.data;
            var citizenDetails = `
            <div class="details">
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-6 fw-bold">
                            Full Name
                        </div>
                        <div class="col-md-8 col-sm-6">
                            ${citizen.first_name} ${citizen.last_name}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-6 fw-bold">
                            Email
                        </div>
                        <div class="col-md-8 col-sm-6">
                        ${citizen.email}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-6 fw-bold">
                            Contact No
                        </div>
                        <div class="col-md-8 col-sm-6">
                        ${citizen.mobile}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-6 fw-bold">
                            Current Location
                        </div>
                        <div class="col-md-8 col-sm-6">
                        ${citizen.location}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-6 fw-bold">
                            Address
                        </div>
                        <div class="col-md-8 col-sm-6">
                        ${citizen.address_line_one}<br>
                        ${citizen.address_line_two}<br>
                        ${citizen.city}<br>
                        ${citizen.postal_code}
                        </div>
                    </div>
                </div>
            `;

            $("#citizenDetailsModalBody").empty().append(citizenDetails);
        });
    }



    $(document).ready(function() {

        $("#updateStaffForm").submit(function(event) {
            event.preventDefault();

            var formData = {
                firstName: $("#staffFirstName").val(),
                lastName: $("#staffLastName").val(),
            };

            $.ajax({
                type: "PUT",
                url: update_staff_url,
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

        // Change Staff Password
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