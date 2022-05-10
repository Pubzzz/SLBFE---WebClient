<?php

if (isset($_COOKIE['access_token'])) {
    $role = $_COOKIE['role'];
    header("Location: " . $role . ".php");
    die();
}

$title = "Login";
include 'include/header.php';

?>

<div class="row mt-4 mb-5 g-0">
    <div class="col-md-4 mx-auto bg-white rounded-3 shadow">
        <h2 class="fw-bolder text-center my-4">Login</h2>
        <div id="alert"></div>
        <form method="post" class="mx-4 mb-5" id="login-form">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="email">Email address</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-dark" type="submit">Login</button>
            </div>
        </form>
    </div>
</div>

<script>
    // if(){

    // }
    var login_url = "http://127.0.0.1:8000/api/v1/login";

    $(document).ready(function() {
        // Post Job Form
        $("#login-form").submit(function(event) {
            // Form Data
            var formData = {
                email: $("#email").val(),
                password: $("#password").val(),
            };

            $.ajax({
                type: "POST",
                url: login_url,
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function(data) {
                document.cookie = `access_token=${data.access_token}; SameSite=None;`;
                document.cookie = `user_id=${data.user_id}; SameSite=None;`;
                document.cookie = `role=${data.role}; SameSite=None;`;

                if (data.role == "citizen") {
                    document.cookie = `nic=${data.nic}; SameSite=None;`;
                    window.location.replace("citizen.php");
                } else if (data.role == "company") {
                    document.cookie = `company_id=${data.company_id}; SameSite=None;`;
                    window.location.replace("company.php");
                } else {
                    window.location.replace("staff.php");
                }

            }).fail(function(data) {
                var alertMessage = `<div class="alert alert-danger mx-4" role="alert">
                                            Invalid Credentials
                                        </div>`;
                $("#alert").empty().append(alertMessage);
            });

            event.preventDefault();
        });
    });
</script>

<?php include 'include/footer.php'; ?>