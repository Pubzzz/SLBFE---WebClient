<?php

if (isset($_COOKIE['access_token']) && $_COOKIE['role'] == "citizen") {

    $access_token = $_COOKIE['access_token'];
    $nic = $_COOKIE['nic'];

    // Headers
    $headers = [
        "Authorization: Bearer " . $access_token . ""
    ];

    $base_path = "http://127.0.0.1:8000/";

    $citizen_url = "http://127.0.0.1:8000/api/v1/citizen/" . $nic;

    // // CURL Citizen
    $citizencUrl = curl_init($citizen_url);
    curl_setopt($citizencUrl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($citizencUrl, CURLOPT_RETURNTRANSFER, true);
    $citizenResponse = curl_exec($citizencUrl);
    curl_close($citizencUrl);
    $citizenData = json_decode($citizenResponse);
    $citizen = $citizenData->data;


    // CURL Industries
    $industriesUrl = "http://127.0.0.1:8000/api/v1/industries";
    $cUrlIndustries = curl_init($industriesUrl);
    curl_setopt($cUrlIndustries, CURLOPT_RETURNTRANSFER, true);
    $responseTwo = curl_exec($cUrlIndustries);
    curl_close($cUrlIndustries);
    $IndustriesData = json_decode($responseTwo);
    $industries = $IndustriesData->industries;
} elseif ($_COOKIE['role'] == "company") {
    header("Location: company.php");
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

<script>
    $(document).ready(function() {
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

        // Documents
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
    });
</script>

<div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-labelledby="uploadDocumentModal" aria-hidden="true">
    <div class="modal-dialog">
        <form id="uploadDocumentForm" method="post" action="" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <script></script>
                    <div class="my-2">
                        <input class="form-control" type="file" id="documentFile" name="file" accept=".jpg, .png, .jpeg, .pdf, .doc">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="uploadQModal" tabindex="-1" aria-labelledby="uploadQModal" aria-hidden="true">
    <div class="modal-dialog">
        <form id="uploadQForm" method="post" action="" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Qualification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <script></script>
                    <div class="my-2">
                        <input class="form-control" type="file" id="qualificationFile" name="file" accept=".jpg, .png, .jpeg, .pdf, .doc">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="container my-5">
    <div class="row">
        <!-- User Profile Sidebar Starts -->
        <div class="col-md-3 col-sm-12 mb-4">
            <div class="bg-white rounded-3 shadow p-3">
                <!-- Profile Starts -->
                <div class="profile text-center">
                    <!-- images/profile.jpg -->
                    <img src="<?php echo $base_path . $citizen->profile_image_path; ?>" width="100" height="100" class="rounded-circle my-2" alt="citizen profile image" data-bs-toggle="modal" data-bs-target="#uploadProfileImageModal">
                    <h5 class="fw-bold"><?php echo $citizen->first_name . " " . $citizen->last_name; ?></h5>
                    <h6 class="text-uppercase"><?php echo $citizen->profession; ?></h6>
                    <span class="fw-light">Member Since : <?php echo date("Y-m-d", strtotime($citizen->user_created_at)); ?></span>

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
                            Documents
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
                            <?php if ($citizen->user_status == "verified") { ?>
                                <i class="bi bi-check-circle-fill text-success fs-6"> Verified</i>
                            <?php } else { ?>
                                <i class="bi bi-exclamation-triangle-fill text-secondary fs-6"> Not Verified</i>
                            <?php } ?>
                        </div>

                        <div class="col-sm-3">
                            User Status
                        </div>
                        <div class="col-sm-3">
                            <?php if ($citizen->user_status == "active") { ?>
                                <i class="bi bi-check-circle-fill text-success fs-6"> Active</i>
                            <?php } else { ?>
                                <i class="bi bi-x-circle-fill text-danger fs-6"> Blocked</i>
                            <?php } ?>
                        </div>

                        <div class="col-sm-3">
                            Curriculum Vitae (CV)
                        </div>
                        <div class="col-sm-3" id="CVStatus">
                        </div>

                        <div class="col-sm-3">
                            Birth Certificate
                        </div>
                        <div class="col-sm-3" id="birthCertificateStatus">
                        </div>
                    </div>
                </div>
                <!-- Profile Status Ends -->

                <!-- User Personal Details Starts -->
                <div class="px-3">
                    <h5 class="text-uppercase mb-3">Personal Information</h5>
                    <form id="citizenUpdateForm">
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">First Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="firstName" value="<?php echo $citizen->first_name; ?>" required>
                            </div>
                            <label for="staticEmail" class="col-sm-2 col-form-label">Last Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="lastName" value="<?php echo $citizen->last_name; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" readonly id="email" value="<?php echo $citizen->email; ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="nic" class="col-sm-2 col-form-label">NIC</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" readonly id="nic" value="<?php echo $citizen->nic; ?>">
                            </div>
                            <div class="col-sm-2" id="NICStatus">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Passport No</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="passportNo" value="<?php echo $citizen->passport_no; ?>">
                            </div>
                            <label for="staticEmail" class="col-sm-2 col-form-label">Expiry Date</label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="passportExpiryDate" value="<?php echo $citizen->passport_expiry_date; ?>">
                            </div>
                            <div class="col-sm-2" id="PassportStatus">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Date Of Birth</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="dob" value="<?php echo date("Y-m-d", strtotime($citizen->date_of_birth)); ?>" required>
                            </div>
                            <label for="staticEmail" class="col-sm-2 col-form-label">Mobile</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="mobile" value="<?php echo $citizen->mobile; ?>" required>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-uppercase mb-3">Employment Status</h6>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Profession</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="profession" value="<?php echo $citizen->profession; ?>">
                            </div>
                            <label for="employeeName" class="col-sm-2 col-form-label">Company</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="employeeName" value="<?php echo $citizen->employee_name; ?>">
                            </div>

                        </div>

                        <div class="mb-3 row">
                            <label for="employeeName" class="col-sm-2 col-form-label">Experience</label>
                            <div class="col-sm-4">

                                <select class="form-select" aria-label=".form-select example" id="expLevel" required>
                                    <option value="Junior">Junior</option>
                                    <option value="Mid-Level">Mid-Level</option>
                                    <option value="Senior">Senior</option>
                                </select>
                                <!-- <input type="text" class="form-control"  value=""> -->
                            </div>
                            <label for="staticEmail" class="col-sm-2 col-form-label">Industry</label>
                            <div class="col-sm-4">
                                <select class="form-select" aria-label=".form-select industries" required id="industry">
                                    <?php foreach ($industries as $industry) { ?>
                                        <option <?php if ($industry->name == $citizen->name) {
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

                <!-- Address Starts-->
                <div class="px-3 mt-4">
                    <h5 class="text-uppercase mb-3">Address</h5>
                    <form id="addressUpdateForm">
                        <div class="mb-3 row">
                            <label for="addressLineOne" class="col-sm-3 col-form-label">Address Line One</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="addressLineOne" value="<?php echo $citizen->address_line_one; ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="addressLineTwo" class="col-sm-3 col-form-label">Address Line One</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="addressLineTwo" value="<?php echo $citizen->address_line_two; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="city" class="col-sm-3 col-form-label">City</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="city" value="<?php echo $citizen->city; ?>" required>
                            </div>
                            <label for="postalCode" class="col-sm-2 col-form-label">Postal Code</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="postalCode" value="<?php echo $citizen->postal_code; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="addressLineOne" class="col-sm-3 col-form-label">Current Location</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="location" value="<?php echo $citizen->location; ?>">
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
                <!-- Address Ends-->

                <!-- Qualifications Starts-->
                <div class="px-3 mt-4">
                    <h5 class="text-uppercase mb-3">Qualifications <span><button type="button" class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#addNewQModal">New</button></span></h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Type</th>
                                <th scope="col">Field</th>
                                <th scope="col">Title</th>
                                <th scope="col">School/ University</th>
                            </tr>
                        </thead>
                        <tbody id="qualificationBody">

                        </tbody>
                    </table>
                </div>
                <!-- Qualifications Ends-->
            </div>
            <!-- Profile Ends -->

            <input type="text" id="accessToken" required value="<?php echo $access_token; ?>" hidden>


            <!-- Documents and Qualifications Starts -->
            <div class="bg-white rounded-3 shadow p-3" id="documents">
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
                            <th scope="col">Verification Status</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="qBodyTwo">
                    </tbody>
                </table>
            </div>
            <!-- Documents and Qualifications Ends -->

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



<!-- Upload Profile Image Modal -->
<div class="modal fade" id="uploadProfileImageModal" tabindex="-1" aria-labelledby="uploadProfileImageModal" aria-hidden="true">
    <div class="modal-dialog">
        <form id="uploadProfileImage" method="post" action="" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload a Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-2">
                        <input class="form-control" type="file" id="profileImage" name="file" accept=".jpg, .png, .jpeg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Upload Profile Image Modal -->

<!-- Add New Qualification Modal -->
<div class="modal fade" id="addNewQModal" tabindex="-1" aria-labelledby="addNewQModal" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addNewQualification" method="post" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Qualification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="qualificationType" aria-label="Floating label select" required>
                            <option selected value="1">High School Diploma</option>
                            <option value="2">Certificate</option>
                            <option value="3">HND/ Advanced Diploma</option>
                            <option value="4">Bachelor's Degree</option>
                            <option value="5">Master's Degree</option>
                        </select>
                        <label for="floatingSelect">Qualification Type</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="qTitle" placeholder="Advanced Diploma in CS" required>
                        <label for="floatingInput">Title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="field" placeholder="Information Technology" required>
                        <label for="floatingInput">Field</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="schoolUniversity" placeholder="ABC School" required>
                        <label for="floatingInput">School or University Name</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Add New Qualification Modal -->



<script>
    var access_token = $("#accessToken").val();
    var nic = $("#nic").val();

    var base_path = "http://127.0.0.1:8000/api/v1/";
    var resource_path = "http://127.0.0.1:8000/";

    var documents_url = `${base_path}citizen/documents/${nic}`;
    var qualifications_url = `${base_path}citizen/qualifications/${nic}`;

    function deleteDocument(documentId) {
        var delete_document_url = `${base_path}citizen/document/${documentId}`;
        $.ajax({
            type: "DELETE",
            url: delete_document_url,
            headers: {
                "Authorization": `Bearer  ${access_token}`
            },
            success: function(response) {
                location.reload();
            }
        });
    }

    function uploadDocument(documentId) {
        var uploadDocumentId = documentId;
        $('#uploadDocumentModal').modal('toggle');

        $("#uploadDocumentForm").submit(function(event) {
            event.preventDefault();

            var upload_document_url = `${base_path}citizen/upload/document/${uploadDocumentId}`;
            let formData = new FormData();
            formData.append("file", documentFile.files[0]);

            $.ajax({
                url: upload_document_url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "Authorization": `Bearer  ${access_token}`
                },

            }).done(function(data) {
                location.reload();
            });
        });
    }

    function deleteQualification(id) {
        var delete_qualification_url = `${base_path}citizen/qualification/${id}`;
        $.ajax({
            type: "DELETE",
            url: delete_qualification_url,
            headers: {
                "Authorization": `Bearer  ${access_token}`
            },
            success: function(response) {
                location.reload();
            }
        });
    }

    function uploadQualification(id) {
        var uploadQId = id;
        $('#uploadQModal').modal('toggle');

        $("#uploadQForm").submit(function(event) {
            event.preventDefault();

            var upload_qualification_url = `${base_path}citizen/upload/qualification/${uploadQId}`;
            let formData = new FormData();
            formData.append("file", qualificationFile.files[0]);

            $.ajax({
                url: upload_qualification_url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "Authorization": `Bearer  ${access_token}`
                },

            }).done(function(data) {
                location.reload();
            });
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
                var qualificationRow = `
                <tr>
                    <th>${val.type}</th>
                    <td>${val.field}</td>
                    <td>${val.title}</td>
                    <td>${val.school_university}</td>
                </tr>
                `;

                if (val.status == "verified" || val.status == "unverified") {
                    var status = `
                            <a href="${resource_path + val.file_path}" target="_blank"><span class="text-success"><i class="bi bi-download"></i></span></a>
                            <span class="text-secondary"><i class="bi bi bi-upload"></i></span></a>
                            <a onclick="deleteQualification(${val.id})" style="cursor: pointer;"><span class="text-danger"><i class="bi bi-trash"></i></span></a>
                        `;
                } else {
                    var status = `
                            <span class="text-secondary"><i class="bi bi-download"></i></span>
                            <a onclick="uploadQualification(${val.id})"><span class="text-primary" style="cursor: pointer;"><i class="bi bi bi-upload"></i></span></a>
                            <span class="text-secondary"><i class="bi bi-trash"></i></span>`;
                }

                var qVerifyRow = `
                <tr>
                    <th>${val.type}</th>
                    <td>${val.title}</td>
                    <td>${val.status}</td>
                    <td>${status}</td>
                </tr>
                `;

                $("#qualificationBody").append(qualificationRow);
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

                if (val.type == "Birth Certificate") {
                    type = "birthCertificate";
                } else {
                    type = val.type;
                }

                // Status
                if (val.status == "verified") {
                    var status = `
                            <a href="${resource_path + val.file_path}" target="_blank"><span class="text-success"><i class="bi bi-download"></i></span></a>
                            <span class="text-secondary"><i class="bi bi bi-upload"></i></span></a>
                            <a onclick="deleteDocument(${val.id})" style="cursor: pointer;"><span class="text-danger"><i class="bi bi-trash"></i></span></a>
                        `;
                    var displayStatus = `<i class="bi bi-check-circle-fill text-success fs-6"> Verified</i>`;

                } else if (val.status == "unverified") {
                    var status = `
                            <a href="${resource_path + val.file_path}" target="_blank"><span class="text-success"><i class="bi bi-download"></i></span></a>
                            <span class="text-secondary"><i class="bi bi bi-upload"></i></span></a>
                            <a onclick="deleteDocument(${val.id})" style="cursor: pointer;"><span class="text-danger"><i class="bi bi-trash"></i></span></a>
                        `;
                    var displayStatus = `<i class="bi bi-check-circle-fill text-secondary fs-6"> Pending</i>`;

                } else {
                    var status = `
                            <span class="text-secondary"><i class="bi bi-download"></i></span>
                            <a onclick="uploadDocument(${val.id})"><span class="text-primary" style="cursor: pointer;"><i class="bi bi bi-upload"></i></span></a>
                            <span class="text-secondary"><i class="bi bi-trash"></i></span>`;

                    var displayStatus = `<i class="bi bi-exclamation-triangle-fill text-warning fs-6"> Upload</i>`;
                }

                $(`#${type}Status`).append(displayStatus);

                var document = `
                    <tr>
                        <td>${val.type}</td>
                        <td>${val.status}</td>
                        <td>${created_at}</td>
                        <td class="text-end">
                            ${status}
                        </td>
                    </tr>`;

                $("#documentBody").append(document);
            });
        }
    });

    $(document).ready(function() {
        var adress_update_url = `${base_path}citizen/address`;
        var citizen_update_url = `${base_path}citizen`;
        var change_password_url = `${base_path}change-password`;
        var upload_profile_url = `${base_path}citizen/upload-profile-image`;
        var new_qualification_url = `${base_path}citizen/qualification`;

        $("#citizenUpdateForm").submit(function(event) {
            event.preventDefault();

            var formData = {
                firstName: $("#firstName").val(),
                lastName: $("#lastName").val(),
                nic: $("#nic").val(),
                passportNo: $("#passportNo").val(),
                passportExpiryDate: $("#passportExpiryDate").val(),
                dob: $("#dob").val(),
                mobile: $("#mobile").val(),
                profession: $("#profession").val(),
                employeeName: $("#employeeName").val(),
                expLevel: $("#expLevel").val(),
                industryId: $("#industry").val(),
            };

            $.ajax({
                type: "PUT",
                url: citizen_update_url,
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

        $("#addressUpdateForm").submit(function(event) {
            event.preventDefault();
            var locationData = {
                location: $("#location").val(),
            };

            $.ajax({
                type: "PUT",
                url: `${base_path}citizen/location/${nic}`,
                data: locationData,
                dataType: "json",
                headers: {
                    "Authorization": `Bearer  ${access_token}`
                },
                encode: true,

            });

            var formData = {
                addressLineOne: $("#addressLineOne").val(),
                addressLineTwo: $("#addressLineTwo").val(),
                city: $("#city").val(),
                postalCode: $("#postalCode").val(),
            };

            $.ajax({
                type: "PUT",
                url: adress_update_url,
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

        $("#uploadProfileImage").submit(function(event) {
            event.preventDefault();

            let formData = new FormData();
            formData.append("file", profileImage.files[0]);

            $.ajax({
                url: upload_profile_url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "Authorization": `Bearer  ${access_token}`
                },

            }).done(function(data) {
                location.reload();
            });
        });

        $("#addNewQualification").submit(function(event) {
            event.preventDefault();

            var formData = {
                qualificationType: $("#qualificationType").val(),
                title: $("#title").val(),
                field: $("#field").val(),
                schoolUniversity: $("#schoolUniversity").val(),
            };

            $.ajax({
                type: "POST",
                url: new_qualification_url,
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

        $("#updateQualification").submit(function(event) {
            event.preventDefault();

            var formData = {
                qualificationType: $("#qualificationType").val(),
                title: $("#title").val(),
                field: $("#field").val(),
                schoolUniversity: $("#schoolUniversity").val(),
            };

            $.ajax({
                type: "POST",
                url: new_qualification_url,
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