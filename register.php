<?php

if (isset($_COOKIE['access_token'])) {
    $role = $_COOKIE['role'];
    header("Location: " . $role . ".php");
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

$title = "Sign Up";
include 'include/header.php';

?>



<div class="row mt-4 mb-5 g-0">
    <div class="col-md-4 mx-auto bg-white rounded-3 shadow">
        <h2 class="fw-bolder text-center my-4">Sign Up</h2>
        <div class="mx-4 mb-5">

            <form id="form">
                <div id="basicForm">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="role" aria-label="Floating label select role">
                            <option value="citizen">Citizen</option>
                            <option value="company">Company</option>
                        </select>
                        <label for="role">Select User Type</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com">
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="firstName" placeholder="John">
                        <label for="firstName">First Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="lastName" placeholder="Doe">
                        <label for="lastName">Last Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" placeholder="Password">
                        <label for="password">Password</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Password">
                        <label for="confirmPassword">Confirm Password</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" id="firstFormNext" type="button">Next</button>
                    </div>
                </div>


                <div id="companyForm" hidden>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="companyName" placeholder="John">
                        <label for="firstName">Company Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select mb-3" aria-label=".form-select industries" required id="industry">
                            <?php foreach ($industries as $industry) { ?>
                                <option value="<?php echo $industry->id; ?>">
                                    <?php echo $industry->name; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label for="role">Industry</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="location" placeholder="Doe">
                        <label for="lastName">Location</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="contactNo" placeholder="Doe">
                        <label for="lastName">Contact No</label>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="companyFormBack" type="button">Previous</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="companySubmit" type="button">Sign Up</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="citizenFormOne" hidden>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nic" placeholder="123456789V">
                        <label for="nic">NIC</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="dob" placeholder="2020-01-01">
                        <label for="dob">Date of Birth</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="mobile" placeholder="009477123456789">
                        <label for="mobile">Mobile</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select mb-3" aria-label=".form-select industries" required id="citizenIndustry">
                            <?php foreach ($industries as $industry) { ?>
                                <option value="<?php echo $industry->id; ?>">
                                    <?php echo $industry->name; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label for="role">Industry</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="profession" placeholder="Software Developer">
                        <label for="profession">Profession</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="expLevel" aria-label="Floating label select role">
                            <option value="junior">Junior</option>
                            <option value="Mid-Level">Mid-Level</option>
                            <option value="Senior">Senior</option>
                        </select>
                        <label for="role">Experiance Level</label>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="citizenFormBack" type="button">Previous</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="citizenFormNext" type="button">Next</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="citizenFormTwo" hidden>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="addressLineOne" placeholder="12/A">
                        <label for="addressLineOne">Address Line One</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="addressLineTwo" placeholder="Main Street">
                        <label for="addressLineTwo">Address Line One</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="city" placeholder="Colombo">
                        <label for="city">City</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="postalCode" placeholder="12000">
                        <label for="postalCode">Postal Code</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="citizenLocation" placeholder="New York, USA">
                        <label for="location">Current Location</label>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="citizenTwoBack" type="button">Previous</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="citizenSubmit" type="button">Sign Up</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    var base_path = "http://127.0.0.1:8000/api/v1/";

    var register_url = `${base_path}register`;

    $("#firstFormNext").click(function() {
        // Password Check
        if ($("#password").val() == $("#confirmPassword").val()) {
            $("#basicForm").hide();
            // If User Selects Company
            if ($("#role").val() == "company") {
                $('#companyForm').removeAttr('hidden');
                $('#companyForm').show();

                $("#companyFormBack").click(function() {
                    $("#basicForm").show();
                    $('#companyForm').hide();
                });

                // Company Form Data
                $("#companySubmit").click(function() {
                    var formData = {
                        firstName: $("#firstName").val(),
                        lastName: $("#lastName").val(),
                        role: $("#role").val(),
                        email: $("#email").val(),
                        password: $("#password").val(),
                        companyName: $("#companyName").val(),
                        location: $("#location").val(),
                        industryId: $("#industry").val(),
                        contactNo: $("#contactNo").val(),
                    };

                    // Register Company User
                    $.ajax({
                        type: "POST",
                        url: register_url,
                        data: formData,
                        dataType: "json",
                        encode: true,
                    }).done(function(data) {
                        document.cookie = `access_token=${data.access_token}; SameSite=None;`;
                        document.cookie = `user_id=${data.user_id}; SameSite=None;`;
                        document.cookie = `role=${data.role}; SameSite=None;`;
                        document.cookie = `company_id=${data.company_id}; SameSite=None;`;
                        window.location.replace("company.php")
                    });
                });
            } else if ($("#role").val() == "citizen") {
                // Show Citizen Form One
                $('#citizenFormOne').removeAttr('hidden');
                $('#citizenFormOne').show();

                $("#citizenFormBack").click(function() {
                    $("#basicForm").show();
                    $('#citizenFormOne').hide();
                });

                $("#citizenFormNext").click(function() {
                    $("#citizenFormOne").hide();
                    $('#citizenFormTwo').removeAttr('hidden'); // Show Citizen Form Two
                    $('#citizenFormTwo').show();

                    $("#citizenTwoBack").click(function() {
                        $("#citizenFormOne").show();
                        $('#citizenFormTwo').hide();
                    });

                    $("#citizenSubmit").click(function() {
                        var formData = {
                            firstName: $("#firstName").val(),
                            lastName: $("#lastName").val(),
                            role: $("#role").val(),
                            email: $("#email").val(),
                            password: $("#password").val(),
                            nic: $("#nic").val(),
                            dob: $("#dob").val(),
                            mobile: $("#mobile").val(),
                            profession: $("#profession").val(),
                            industryId: $("#citizenIndustry").val(),
                            expLevel: $("#expLevel").val(),
                            addressLineOne: $("#addressLineOne").val(),
                            addressLineTwo: $("#addressLineTwo").val(),
                            city: $("#city").val(),
                            postalCode: $("#postalCode").val(),
                            location: $("#citizenLocation").val(),
                        };

                        // Register Company User
                        $.ajax({
                            type: "POST",
                            url: register_url,
                            data: formData,
                            dataType: "json",
                            encode: true,
                        }).done(function(data) {
                            document.cookie = `access_token=${data.access_token}; SameSite=None;`;
                            document.cookie = `user_id=${data.user_id}; SameSite=None;`;
                            document.cookie = `role=${data.role}; SameSite=None;`;
                            document.cookie = `nic=${data.nic}; SameSite=None;`;
                            window.location.replace("citizen.php");
                        });
                    });
                });
            }
        } else {
            console.log("Password Mismatch");
        }
    });
</script>

<?php include 'include/footer.php'; ?>